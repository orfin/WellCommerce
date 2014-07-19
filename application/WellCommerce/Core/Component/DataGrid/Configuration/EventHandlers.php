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
 * Class EventHandlers
 *
 * @package WellCommerce\Core\Component\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EventHandlers extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'load',
            'process',
            'select',
            'deselect',
            'click_row',
            'view_row',
            'selection_changed',
            'delete_row',
            'edit_row',
            'update_row',
            'delete_group',
            'open_context_menu',
            'loaded',
        ]);

        $resolver->setDefaults([
            'load'              => OptionInterface::GF_NULL,
            'process'           => OptionInterface::GF_NULL,
            'select'            => OptionInterface::GF_NULL,
            'deselect'          => OptionInterface::GF_NULL,
            'click_row'         => OptionInterface::GF_NULL,
            'view_row'          => OptionInterface::GF_NULL,
            'selection_changed' => OptionInterface::GF_NULL,
            'delete_row'        => OptionInterface::GF_NULL,
            'edit_row'          => OptionInterface::GF_NULL,
            'update_row'        => OptionInterface::GF_NULL,
            'delete_group'      => OptionInterface::GF_NULL,
            'open_context_menu' => OptionInterface::GF_NULL,
            'loaded'            => OptionInterface::GF_NULL,
        ]);

        $resolver->setAllowedTypes([
            'load'              => ['int', 'string'],
            'process'           => ['int', 'string'],
            'select'            => ['int', 'string'],
            'deselect'          => ['int', 'string'],
            'click_row'         => ['int', 'string'],
            'view_row'          => ['int', 'string'],
            'selection_changed' => ['int', 'string'],
            'delete_row'        => ['int', 'string'],
            'edit_row'          => ['int', 'string'],
            'update_row'        => ['int', 'string'],
            'delete_group'      => ['int', 'string'],
            'open_context_menu' => ['int', 'string'],
            'loaded'            => ['int', 'string'],
        ]);
    }
}