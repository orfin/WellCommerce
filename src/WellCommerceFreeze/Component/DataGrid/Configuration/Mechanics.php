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

namespace WellCommerce\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Mechanics
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Mechanics extends AbstractOption
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'rows_per_page',
            'key',
        ]);

        $resolver->setDefaults([
            'rows_per_page'            => 50,
            'key'                      => 'id',
            'default_sorting'          => -9999,
            'right_click_menu'         => false,
            'auto_suggest_delay'       => 500,
            'auto_suggest_min_length'  => 3,
            'auto_suggest_suggestions' => 10,
            'only_one_selected'        => false,
            'no_column_modification'   => false,
            'no_column_resizing'       => false,
            'create_input'             => false,
            'save_column_modification' => true,
            'persistent'               => true,
        ]);

        $resolver->setAllowedTypes('rows_per_page', 'int');
        $resolver->setAllowedTypes('key', ['int', 'string']);
        $resolver->setAllowedTypes('default_sorting', ['int', 'string']);
        $resolver->setAllowedTypes('right_click_menu', 'bool');
        $resolver->setAllowedTypes('auto_suggest_delay', 'int');
        $resolver->setAllowedTypes('auto_suggest_min_length', 'int');
        $resolver->setAllowedTypes('auto_suggest_suggestions', 'int');
        $resolver->setAllowedTypes('only_one_selected', 'bool');
        $resolver->setAllowedTypes('no_column_modification', 'bool');
        $resolver->setAllowedTypes('no_column_resizing', 'bool');
        $resolver->setAllowedTypes('create_input', 'bool');
        $resolver->setAllowedTypes('save_column_modification', 'bool');
        $resolver->setAllowedTypes('persistent', 'bool');
    }
}
