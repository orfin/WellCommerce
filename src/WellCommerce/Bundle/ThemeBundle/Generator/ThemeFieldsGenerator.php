<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ThemeBundle\Generator;

use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\AppBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\ThemeBundle\Entity\Theme;
use WellCommerce\Component\Form\Elements\Form;
use WellCommerce\Component\Form\Elements\Input\TextField;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class ThemeFieldsGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFieldsGenerator extends AbstractContainer implements ContainerAwareInterface
{
    protected $nextFieldId       = 0;
    protected $layoutBoxSelector;
    protected $themeDir;
    protected $configurationFile = 'fields.xml';
    protected $defaultValues;
    
    /**
     * @var Theme
     */
    protected $theme;
    
    /**
     * @var FormBuilderInterface
     */
    protected $builder;
    
    /**
     * @var Form
     */
    protected $form;
    
    /**
     * @var \DOMDocument
     */
    protected $configuration;
    
    /**
     * Initializes generator configuration
     *
     * @param Theme  $theme
     * @param string $layoutBoxSelector
     */
    public function loadThemeFieldsConfiguration(Theme $theme, $layoutBoxSelector = '.layout-box')
    {
        $this->theme             = $theme;
        $this->themeDir          = $this->getDirectory();
        $this->configuration     = $this->loadConfiguration();
        $this->layoutBoxSelector = $layoutBoxSelector;
    }
    
    /**
     * Returns theme working directory
     *
     * @return string
     */
    private function getDirectory()
    {
        return $this->getThemeDir($this->theme->getFolder());
    }
    
    /**
     * Loads fields configuration from fields.xml file
     *
     * @return \DOMDocument|null
     * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
     */
    private function loadConfiguration()
    {
        $finder = new Finder();
        $files  = $finder->files()->in($this->themeDir)->name($this->configurationFile);
        if ($files->count() == 0) {
            throw new FileNotFoundException('Theme configuration file "fields.xml" was not found.');
        }
        
        /**
         * @var $file \SplFileInfo
         */
        foreach ($files as $file) {
            return $this->loadFile($file->getRealpath());
        }
        
        return null;
    }
    
    /**
     * Parses XML file
     *
     * @param $file
     *
     * @return \DOMDocument
     */
    private function loadFile($file)
    {
        return XmlUtils::loadFile($file);
    }
    
    /**
     * Adds required theme configuration fields to form
     *
     * @param FormBuilderInterface $builder
     */
    public function addFormFields(FormBuilderInterface $builder)
    {
        $this->builder = $builder;
        $this->form    = $builder->getForm();
        
        foreach ($this->configuration->documentElement->getElementsByTagName('fieldset') as $fieldset) {
            $this->addFieldset($fieldset);
        }
    }
    
    /**
     * Adds new configuration fieldset to form
     *
     * @param \DOMElement $node
     */
    protected function addFieldset(\DOMElement $node)
    {
        $fieldset = $this->form->addChild($this->builder->getElement('fieldset', [
            'name'  => $node->getAttribute('name'),
            'label' => $this->trans($node->getAttribute('label'))
        ]));
        
        foreach ($node->getElementsByTagName('field') as $field) {
            if (false !== $element = $this->addField($field)) {
                $element->populate($this->getDefaultValues($field));
                $fieldset->addChild($element);
            }
        }
    }
    
    /**
     * Resolves field type and adds it to fieldset
     *
     * @param \DOMElement $field
     */
    protected function addField(\DOMElement $field)
    {
        $type         = $field->getAttribute('type');
        $functionName = 'addField' . $this->getFieldTypeSuffix($type);
        
        if (!is_callable([$this, $functionName])) {
            return false;
        }
        
        return call_user_func([$this, $functionName], $field);
    }
    
    /**
     * Returns field element suffix
     *
     * @param $type
     *
     * @return mixed
     */
    protected function getFieldTypeSuffix($type)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $type)));
    }
    
    /**
     * Returns default values for field
     *
     * @param $field
     *
     * @return array
     */
    public function getDefaultValues($field)
    {
        $xml = (array)simplexml_import_dom($field);
        if ($xml['default'] instanceof \SimpleXMLElement) {
            $defaultValues = (array)$xml['default'];
        } else {
            $defaultValues = $xml['default'];
        }
        
        return $defaultValues;
    }
    
    /**
     * Adds width input
     *
     * @param \DOMElement $field
     *
     * @return mixed
     */
    protected function addFieldWidth(\DOMElement $field)
    {
        return $this->addSizeInput('width', $this->getFieldAttributes($field));
    }
    
    /**
     * Adds height input
     *
     * @param \DOMElement $field
     *
     * @return mixed
     */
    protected function addFieldHeight(\DOMElement $field)
    {
        return $this->addSizeInput('height', $this->getFieldAttributes($field));
    }
    
    /**
     * Returns text field
     *
     * @param string $type
     * @param array  $attributes
     *
     * @return \WellCommerce\Component\Form\Elements\ElementInterface
     */
    protected function addSizeInput($type, $attributes)
    {
        return $this->builder->getElement('text_field', $attributes + [
                'suffix'        => 'px',
                'size'          => TextField::SIZE_SHORT,
                'css_attribute' => $type,
            ]);
    }
    
    /**
     * Returns an array containing all required field attributes
     *
     * @param $item
     *
     * @return array
     */
    protected function getFieldAttributes(\DOMElement $item)
    {
        $name     = $this->getFieldName($item);
        $label    = '';
        $comment  = '';
        $selector = '';
        
        foreach ($item->childNodes as $child) {
            if (!$child instanceof \DOMElement) {
                continue;
            }
            switch ($child->localName) {
                case 'label':
                    $label = $child->nodeValue;
                    break;
                case 'comment':
                    $comment = $child->nodeValue;
                    break;
                case 'selector':
                    $selector = $this->getFieldSelector($child);
                    break;
            }
        }
        
        return [
            'name'     => $name,
            'label'    => $label,
            'comment'  => $comment,
            'selector' => $selector,
        ];
    }
    
    /**
     * Returns form name or sets it automatically
     *
     * @param \DOMElement $item
     *
     * @return string
     */
    protected function getFieldName(\DOMElement $item)
    {
        $name = $item->getAttribute('name');
        $type = $item->getAttribute('type');
        
        if (empty($name)) {
            $name = 'auto_field_' . ($this->nextFieldId++);
            $item->setAttribute('name', $name);
        }
        
        return sprintf('%s_%s', $name, $type);
    }
    
    /**
     * Returns field specific selector
     *
     * @param \DOMElement $item
     *
     * @return mixed
     */
    protected function getFieldSelector(\DOMElement $item)
    {
        return str_replace('<layout-box/>', $this->layoutBoxSelector, $item->nodeValue);
    }
    
    /**
     * Adds font selector
     *
     * @param \DOMElement $field
     *
     * @return mixed
     */
    protected function addFieldFont(\DOMElement $field)
    {
        $attributes = $this->getFieldAttributes($field);
        $element    = $this->builder->getElement('font_style', $attributes);
        
        return $element;
    }
    
    /**
     * Adds background selector
     *
     * @param \DOMElement $field
     *
     * @return mixed
     */
    protected function addFieldBackground(\DOMElement $field)
    {
        $attributes = $this->getFieldAttributes($field);
        $xml        = simplexml_import_dom($field);
        
        return $this->builder->getElement('colour_scheme_picker', $attributes + [
                'gradient_height' => (string)$xml->height,
                'file_source'     => $this->themeDir . '/assets/images',
                'type_colour'     => (boolean)$xml->type['colour'],
                'type_gradient'   => (boolean)$xml->type['gradient'],
                'type_image'      => (boolean)$xml->type['image'],
            ]);
    }
}
