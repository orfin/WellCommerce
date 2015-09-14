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
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;

/**
 * Interface CartEventDispatcherInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartEventDispatcherInterface
{
    const PRE_CART_CHANGE_EVENT  = 'cart.pre_change';
    const POST_CART_CHANGE_EVENT = 'cart.post_change';

    /**
     * @param CartInterface $cart
     */
    public function dispatchOnPreCartChange(CartInterface $cart);

    /**
     * @param CartInterface $cart
     */
    public function dispatchOnPostCartChange(CartInterface $cart);
}
