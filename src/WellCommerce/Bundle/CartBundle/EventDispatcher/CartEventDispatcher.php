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

namespace WellCommerce\Bundle\CartBundle\EventDispatcher;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\AbstractEventDispatcher;

/**
 * Class CartEventDispatcher
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartEventDispatcher extends AbstractEventDispatcher implements CartEventDispatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreCartChange(CartInterface $cart)
    {
        $event = new CartEvent($cart);
        $this->dispatch(CartEventDispatcherInterface::PRE_CART_CHANGE_EVENT, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostCartChange(CartInterface $cart)
    {
        $event = new CartEvent($cart);
        $this->dispatch(CartEventDispatcherInterface::POST_CART_CHANGE_EVENT, $event);
    }
}
