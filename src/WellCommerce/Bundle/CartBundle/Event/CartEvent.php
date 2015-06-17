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

namespace WellCommerce\Bundle\CartBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\CartBundle\Entity\Cart;

/**
 * Class CartEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartEvent extends Event
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * Constructor
     *
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Returns cart
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
}
