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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityTrait;

/**
 * Class OrderModifier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderModifier implements OrderModifierInterface
{
    use IdentifiableEntityTrait;

    protected $order;
    protected $name;
    protected $description;
    protected $subtraction;
    protected $hierarchy;
    protected $netAmount   = 0;
    protected $grossAmount = 0;
    protected $taxAmount   = 0;
    protected $currency;
    
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        $order->addModifier($this);
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

