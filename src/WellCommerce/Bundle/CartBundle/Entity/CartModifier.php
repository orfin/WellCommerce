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

use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifier;

/**
 * Class CartModifier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartModifier extends OrderModifier implements CartModifierInterface
{
    private $cart;
    private $name;
    private $description;
    private $subtraction;
    private $hierarchy;
    private $netAmount   = 0;
    private $grossAmount = 0;
    private $taxAmount   = 0;
    private $currency;

    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
        $cart->addModifier($this);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function isSubtraction() : bool
    {
        return $this->subtraction;
    }

    public function setSubtraction(bool $subtraction)
    {
        $this->subtraction = $subtraction;
    }

    public function getHierarchy() : int
    {
        return $this->hierarchy;
    }

    public function setHierarchy(int $hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }

    public function getNetAmount() : float
    {
        return $this->netAmount;
    }

    public function setNetAmount(float $netAmount)
    {
        $this->netAmount = $netAmount;
    }

    public function getGrossAmount() : float
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(float $grossAmount)
    {
        $this->grossAmount = $grossAmount;
    }

    public function getTaxAmount() : float
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(float $taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
}

