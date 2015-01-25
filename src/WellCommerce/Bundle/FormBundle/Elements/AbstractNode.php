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

namespace WellCommerce\Bundle\FormBundle\Elements;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\FormBundle\Exception\TransformerNotFoundException;

/**
 * Class AbstractNode
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractNode
{
    /**
     * @var array
     */
    protected $options;

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
            'property_path',
        ]);

        $resolver->setDefaults([
            'class'         => '',
            'property_path' => null,
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getOption('name');
    }

    /**
     * Checks whether element has property_path option
     *
     * @return bool
     */
    public function hasPropertyPath()
    {
        return isset($this->options['property_path']);
    }

    /**
     * {@inheritdoc}
     */
    public function getPropertyPath($indexNotation = false)
    {
        $path = $this->getOption('property_path');

        if (null !== $path && $indexNotation) {
            return sprintf('[%s]', $path);
        }

        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTransformer()
    {
        return isset($this->options['transformer']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransformer()
    {
        if (!$this->hasTransformer()) {
            throw new TransformerNotFoundException($this->getName(), get_class($this));
        }

        return $this->getOption('transformer');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {
        if ($this->hasOption('default')) {
            return $this->getOption('default');
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($option)
    {
        return isset($this->options[$option]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Prepares repetition options for element
     *
     * @return array
     */
    protected function prepareRepetitions()
    {
        return [
            'iMin' => $this->options['repeat_min'],
            'iMax' => $this->options['repeat_max'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        $collection->add(new Attribute('sName', $this->getName()));
        $collection->add(new Attribute('sLabel', $this->getOption('label')));
        $collection->add(new Attribute('sClass', $this->getOption('class')));
        $collection->add(new Attribute('fType', $this->getJavascriptNodeName($this), Attribute::TYPE_FUNCTION));
    }

    /**
     * Returns element javascript-friendly name
     *
     * @param ElementInterface $element
     *
     * @return string
     */
    protected function getJavascriptNodeName(ElementInterface $element)
    {
        $class = $this->getElementClass($element);
        $parts = explode('\\', $class);

        return 'GForm'.end($parts);
    }

    /**
     * Returns FQCN for element
     *
     * @param ElementInterface $element
     *
     * @return string
     */
    protected function getElementClass(ElementInterface $element)
    {
        return ltrim(ClassUtils::getClass($element), '\\');
    }

    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
}
