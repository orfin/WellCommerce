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

/**
 * Class OrderProductTotal
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductTotal
{
    protected $quantity   = 0;
    protected $weight     = 0.00;
    protected $netPrice   = 0.00;
    protected $grossPrice = 0.00;
    protected $taxAmount  = 0.00;
    
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }
    
    public function getWeight(): float
    {
        return $this->weight;
    }
    
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }
    
    public function getNetPrice(): float
    {
        return $this->netPrice;
    }
    
    public function setNetPrice(float $netPrice)
    {
        $this->netPrice = $netPrice;
    }
    
    public function getGrossPrice(): float
    {
        return $this->grossPrice;
    }
    
    public function setGrossPrice(float $grossPrice)
    {
        $this->grossPrice = $grossPrice;
    }
    
    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }
    
    public function setTaxAmount(float $taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }
}
