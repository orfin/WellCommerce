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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ViewRow
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ViewRowEventHandler
{
    public function getEventName()
    {
        return 'view_row';
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