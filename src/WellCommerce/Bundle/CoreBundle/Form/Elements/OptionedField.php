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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\Form\Option;

/**
 * Class OptionedField
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class OptionedField extends Field
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
        ]);

        $resolver->setOptional([
            'options',
            'comment',
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
            'default'         => ['string', 'integer'],
            'rules'           => 'array',
            'dependencies'    => 'array',
            'property_path'   => ['null', 'object'],
            'transformer'     => ['null', 'object'],
        ]);
    }

    /**
     * Adds new option to select
     *
     * @param Option $option
     */
    public function addOption(Option $option)
    {
        $this->attributes['options'][] = $option;
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
