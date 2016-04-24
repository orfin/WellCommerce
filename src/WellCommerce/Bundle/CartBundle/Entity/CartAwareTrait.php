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

namespace WellCommerce\Bundle\CartBundle\Entity;

/**
 * Class CartAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait CartAwareTrait
{
    private $cart;

    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function getCart() : CartInterface
    {
        return $this->cart;
    }

    public function hasCart() : bool
    {
        return $this->cart instanceof CartInterface;
    }
}
