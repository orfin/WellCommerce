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

namespace WellCommerce\Bundle\ShippingBundle\Context;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingSubjectInterface;

/**
 * Class CartContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartContext implements ShippingSubjectInterface
{
    /**
     * @var CartInterface
     */
    private $cart;

    /**
     * CartContext constructor.
     *
     * @param CartInterface $cart
     */
    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function getQuantity() : int
    {
        return $this->cart->getProductTotal()->getQuantity();
    }
    
    public function getWeight() : float
    {
        return $this->cart->getProductTotal()->getWeight();
    }

    public function getNetPrice() : float
    {
        return $this->cart->getProductTotal()->getNetPrice();
    }

    public function getGrossPrice() : float
    {
        return $this->cart->getProductTotal()->getGrossPrice();
    }

    public function getTaxAmount() : float
    {
        return $this->cart->getProductTotal()->getTaxAmount();
    }
    
    public function getCurrency() : string
    {
        return $this->cart->getCurrency();
    }
}
