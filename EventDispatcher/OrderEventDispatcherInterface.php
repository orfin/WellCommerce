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

namespace WellCommerce\Bundle\OrderBundle\EventDispatcher;

/**
 * Interface OrderEventDispatcherInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderEventDispatcherInterface
{
    const POST_ORDER_PREPARED_EVENT = 'post_prepared';

    /**
     * Dispatches an event soon after order is prepared in checkout process
     *
     * @param object $resource
     */
    public function dispatchOnPostOrderPrepared($resource);
}
