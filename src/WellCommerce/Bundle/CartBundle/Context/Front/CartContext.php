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
class CartContext implements CartContextInterface
{
    /**
     * @var CartInterface
     */
    protected $currentCart;

    /**
     * {@inheritdoc}
     */
    public function setCurrentCart(CartInterface $cart)
    {
        $this->currentCart = $cart;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCart()
    {
        return $this->currentCart;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCartIdentifier()
    {
        if ($this->hasCurrentCart()) {
            return $this->currentCart->getId();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentCart()
    {
        return $this->currentCart instanceof CartInterface;
    }
}
