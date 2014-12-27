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

use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function configureAttributes(OptionsResolver $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'options'
        ]);

        $resolver->setDefined([
            'suffix',
            'prefix',
            'error',
            'selector',
            'css_attribute',
            'addable',
            'onAdd',
            'add_item_prompt',
            'default',
            'property_path',
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'default'       => null,
            'options'       => [],
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'property_path' => null,
            'transformer'   => null
        ]);

        $resolver->setAllowedTypes([
            'name'            => 'string',
            'label'           => 'string',
            'options'         => 'array',
            'comment'         => 'string',
            'suffix'          => 'string',
            'prefix'          => 'string',
            'error'           => 'string',
            'selector'        => 'string',
            'css_attribute'   => 'string',
            'addable'         => 'bool',
            'onAdd'           => 'string',
            'add_item_prompt' => 'string',
            'default'         => ['string', 'integer', 'null'],
            'rules'           => 'array',
            'dependencies'    => 'array',
            'property_path'   => ['null', 'object'],
            'transformer'     => ['null', 'object'],
        ]);
    }

    /**
     * Adds new option to select
     *
     * @param $value
     * @param $label
     */
    public function addOption($value, $label)
    {
        $this->attributes['options'][$value] = $label;
    }

    /**
     * Formats field options as javascript
     *
     * @return string
     */
    protected function formatOptionsJs()
    {
        $options = [];
        foreach ($this->attributes['options'] as $value => $label) {
            $value     = addslashes($value);
            $label     = addslashes($label);
            $options[] = "{sValue: '{$value}', sLabel: '{$label}'}";
        }

        return 'aoOptions: [' . implode(', ', $options) . ']';
    }

}
