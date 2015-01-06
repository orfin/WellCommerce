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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class LanguageFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageFieldset extends NestedFieldset implements ElementInterface
{
    protected $locales;

    public function __construct(array $locales)
    {
        parent::__construct();
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'languages',
        ]);

        $resolver->setDefault('languages', $this->locales);

        $resolver->setNormalizer('property_path', function ($options) {
            return new PropertyPath($options['name']);
        });

        $resolver->setAllowedTypes([
            'languages' => 'array',
        ]);
    }

    /**
     * Prepares the languages
     *
     * @return array
     */
    protected function prepareLanguages()
    {
        $options = [];
        foreach ($this->options['languages'] as $language) {
            $options[] = $this->prepareLanguage($language);
        }

        return $options;
    }

    /**
     * Prepares language to use it as element attribute
     *
     * @param $language
     *
     * @return array
     */
    protected function prepareLanguage($language)
    {
        $value = addslashes($language['code']);
        $label = addslashes($language['code']);
        $flag  = addslashes(sprintf('%s.png', substr($label, 0, 2)));

        return [
            'sValue' => $value,
            'sLabel' => $label,
            'sFlag'  => $flag,
        ];
    }

    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'aoLanguages' => $this->prepareLanguages()
        ];
    }

    public function setValue($data)
    {
        $accessor = $this->getPropertyAccessor();
        $data     = $this->convertRepetitionsData($data);

        $this->getChildren()->forAll(function (ElementInterface $child) use ($data, $accessor) {
            $value = $accessor->getValue($data, $child->getPropertyPath(true));
            $child->setValue($value);
        });
    }

    protected function convertRepetitionsData($data)
    {
        $values = [];
        foreach ($data as $locale => $translation) {
            foreach ($translation as $fieldName => $fieldValue) {
                $values[$fieldName][$locale] = $fieldValue;
            }
        }

        return $values;
    }

    public function getValue()
    {
        $values = [];

        $this->getChildren()->forAll(function (ElementInterface $child) use (&$values) {
            foreach ($this->locales as $locale) {
                $values[$locale['code']][$child->getName()] = $this->getChildValue($child, $locale['code']);
            }
        });

        return $values;
    }

    protected function getChildValue(ElementInterface $child, $locale)
    {
        $accessor = $this->getPropertyAccessor();
        $value    = $child->getValue();

        if (is_array($value)) {
            return $accessor->getValue($value, "[{$locale}]");
        }

        return null;
    }
}
