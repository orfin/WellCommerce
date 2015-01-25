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

namespace WellCommerce\Bundle\DataGridBundle\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Mechanics
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Mechanics extends AbstractOption implements OptionInterface
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

        $resolver->setAllowedTypes([
            'rows_per_page'            => 'int',
            'key'                      => ['int', 'string'],
            'default_sorting'          => ['int', 'string'],
            'right_click_menu'         => 'bool',
            'auto_suggest_delay'       => 'int',
            'auto_suggest_min_length'  => 'int',
            'auto_suggest_suggestions' => 'int',
            'only_one_selected'        => 'bool',
            'no_column_modification'   => 'bool',
            'no_column_resizing'       => 'bool',
            'create_input'             => 'bool',
            'save_column_modification' => 'bool',
            'persistent'               => 'bool',
        ]);
    }
}
