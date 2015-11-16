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

namespace WellCommerce\Bundle\SalesBundle\EventDispatcher;

use WellCommerce\Bundle\CoreBundle\EventDispatcher\AbstractEventDispatcher;

/**
 * Class OrderEventDispatcher
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderEventDispatcher extends AbstractEventDispatcher implements OrderEventDispatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostOrderPrepared($resource)
    {
        $this->dispatchResourceEvent($resource, OrderEventDispatcherInterface::POST_ORDER_PREPARED_EVENT);
    }
}
