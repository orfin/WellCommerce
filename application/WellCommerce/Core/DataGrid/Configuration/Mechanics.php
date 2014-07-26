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

namespace WellCommerce\Core\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Mechanics
 *
 * @package WellCommerce\Core\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Mechanics extends AbstractOption implements OptionInterface
{
    protected $types
        = [
            'rows_per_page'            => OptionInterface::TYPE_NUMBER,
            'key'                      => OptionInterface::TYPE_STRING,
            'default_sorting'          => OptionInterface::TYPE_STRING,
            'right_click_menu'         => OptionInterface::TYPE_BOOLEAN,
            'auto_suggest_delay'       => OptionInterface::TYPE_NUMBER,
            'auto_suggest_min_length'  => OptionInterface::TYPE_NUMBER,
            'auto_suggest_suggestions' => OptionInterface::TYPE_NUMBER,
            'only_one_selected'        => OptionInterface::TYPE_BOOLEAN,
            'no_column_modification'   => OptionInterface::TYPE_BOOLEAN,
            'no_column_resizing'       => OptionInterface::TYPE_BOOLEAN,
            'create_input'             => OptionInterface::TYPE_BOOLEAN,
            'save_column_modification' => OptionInterface::TYPE_BOOLEAN,
            'persistent'               => OptionInterface::TYPE_BOOLEAN,
        ];

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'rows_per_page',
            'key',
        ]);

        $resolver->setOptional([
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
            'persistent'
        ]);

        $resolver->setDefaults([
            'rows_per_page' => 50,
            'key'           => 'id',
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