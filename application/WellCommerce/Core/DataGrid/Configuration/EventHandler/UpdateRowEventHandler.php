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

namespace WellCommerce\Core\DataGrid\Configuration\EventHandler;


use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpdateRowEventHandler
{
    public function getEventName()
    {
        return 'update_row';
    }

    public function configure(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'callback',
            'success_message',
            'error_message',
        ]);
    }
}