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

namespace WellCommerce\Bundle\CartBundle\Context\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Class CartContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartContext implements CartContextInterface
{
    /**
     * @var CartInterface
     */
    private $currentCart;

    public function setCurrentCart(CartInterface $cart)
    {
        $this->currentCart = $cart;
    }

    public function getCurrentCart() : CartInterface
    {
        return $this->currentCart;
    }

    public function getCurrentCartIdentifier() : int
    {
        if ($this->hasCurrentCart()) {
            return $this->getCurrentCart()->getId();
        }
        
        return 0;
    }

    public function hasCurrentCart() : bool
    {
        return $this->currentCart instanceof CartInterface;
    }
}
