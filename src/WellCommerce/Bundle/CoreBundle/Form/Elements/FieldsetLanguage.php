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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class FieldsetLanguage
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FieldsetLanguage extends Fieldset implements ElementInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param LocaleRepositoryInterface $repository
     */
    public function __construct(LocaleRepositoryInterface $repository)
    {
        $this->repository           = $repository;
        $this->options['languages'] = $repository->getAvailableLocales();
        parent::__construct($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'languages'
        ]);

        $resolver->setOptional([
            'class',
            'label',
            'repeat_min',
            'repeat_max',
            'property_path',
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'property_path' => null,
            'transformer'   => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'languages'     => [],
            'repeat_min'    => function (Options $options) {
                    return count($options['languages']);
                },
            'repeat_max'    => function (Options $options) {
                    return count($options['languages']);
                },
        ]);

        $resolver->setAllowedTypes([
            'name'       => 'string',
            'label'      => 'string',
            'class'      => 'string',
            'languages'  => 'array',
            'repeat_min' => 'integer',
            'repeat_max' => 'integer',
        ]);
    }

    /**
     * Formats field javascript
     *
     * @return string
     */
    protected function formatLanguagesJs()
    {
        $options = [];
        foreach ($this->options['languages'] as $language) {
            $value     = addslashes($language['code']);
            $label     = addslashes($language['code']);
            $flag      = addslashes(sprintf('%s.png', substr($label, 0, 2)));
            $options[] = "{sValue: '{$value}', sLabel: '{$label}',sFlag: '{$flag}' }";
        }

        return 'aoLanguages: [' . implode(', ', $options) . ']';
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatRepeatableJs(),
            $this->formatDependencyJs(),
            $this->formatLanguagesJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = new PropertyPath($this->getName());
    }

    /**
     * Sets default data for all translatable fields bound to fieldset
     *
     * @param $data
     */
    public function setDefaults($data)
    {
        $values       = [];
        $accessor     = $this->getPropertyAccessor();
        $translations = $accessor->getValue($data, $this->getPropertyPath());
        foreach ($this->children as $child) {
            foreach ($translations as $translation) {
                $values[$translation->getLocale()] = $accessor->getValue($translation, $child->getPropertyPath());
                $child->populate($values);
            }
        }
    }

    /**
     * Handles submit request and sets translations for entity
     *
     * @param $data
     */
    public function handleRequest($data)
    {
        $accessor     = $this->getPropertyAccessor();
        foreach ($this->children as $child) {
            $childValues = $child->getValue();
            foreach ($childValues as $locale => $value) {
                $translation = $data->translate($locale);
                $accessor->setValue($translation, $child->getName(), $value);
            }
        }

        $data->mergeNewTranslations();
    }
}
