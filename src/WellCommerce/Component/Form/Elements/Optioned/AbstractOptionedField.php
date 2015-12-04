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

namespace WellCommerce\Component\Form\Elements\Optioned;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;

/**
 * Class AbstractOptionedField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOptionedField extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'options',
        ]);

        $resolver->setDefaults([
            'options' => [],
            'suffix'  => '',
            'prefix'  => ''
        ]);

        $resolver->setAllowedTypes('options', 'array');
        $resolver->setAllowedTypes('suffix', 'string');
        $resolver->setAllowedTypes('prefix', 'string');
    }

    /**
     * Adds new option to select
     *
     * @param $value
     * @param $label
     */
    public function addOptionToSelect($value, $label)
    {
        $this->options['options'][$value] = $label;
    }

    /**
     * Returns options
     *
     * @return array
     */
    protected function getSelectOptions()
    {
        return $this->options['options'];
    }

    /**
     * Formats field options as javascript
     *
     * @return string
     */
    protected function prepareOptions()
    {
        $options = [];
        foreach ($this->getSelectOptions() as $value => $label) {
            $value     = addslashes($value);
            $label     = addslashes($label);
            $options[] = [
                'sValue' => $value,
                'sLabel' => $label,
            ];
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('aoOptions', $this->prepareOptions(), Attribute::TYPE_ARRAY));
    }
}
