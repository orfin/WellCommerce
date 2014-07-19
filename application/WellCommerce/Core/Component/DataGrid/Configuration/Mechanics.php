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

namespace WellCommerce\Core\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Mechanics
 *
 * @package WellCommerce\Core\Component\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Mechanics extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'rows_per_page',
            'key',
            'default_sorting',
            'right_click_menu',
            'auto_suggest_delay',
            'auto_suggest_min_length',
            'auto_suggest_suggestions',
            'only_one_selected',
            'no_column_modification',
            'no_column_resizing',
            'create_input',
            'save_column_modification',
            'persistent',
        ]);

        $resolver->setDefaults([
            'rows_per_page'            => 50,
            'key'                      => OptionInterface::GF_NULL,
            'default_sorting'          => OptionInterface::GF_NULL,
            'right_click_menu'         => false,
            'auto_suggest_delay'       => 500,
            'auto_suggest_min_length'  => 1,
            'auto_suggest_suggestions' => 5,
            'only_one_selected'        => false,
            'no_column_modification'   => false,
            'no_column_resizing'       => false,
            'create_input'             => false,
            'save_column_modification' => true,
            'persistent'               => true,
        ]);

        $resolver->setAllowedTypes([
            'rows_per_page'            => 'int',
            'key'                      => 'int',
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