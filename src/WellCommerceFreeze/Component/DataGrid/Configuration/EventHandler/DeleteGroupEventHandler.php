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

namespace WellCommerce\Component\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DeleteGroupEventHandler
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteGroupEventHandler extends AbstractEventHandler
{
    /**
     * {@inheritdoc}
     */
    public function getFunctionName() : string
    {
        return 'delete_group';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'route',
            'group_action',
        ]);

        $resolver->setDefaults([
            'route'        => false,
            'group_action' => false,
        ]);

        $resolver->setAllowedTypes('route', ['bool', 'string']);
        $resolver->setAllowedTypes('group_action', ['bool', 'string']);
    }
}
