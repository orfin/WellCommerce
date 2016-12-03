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
 * Class OrderSummary
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderSummary
{
    private $netAmount   = 0;
    private $grossAmount = 0;
    private $taxAmount   = 0;
    
    public function getNetAmount(): float
    {
        return $this->netAmount;
    }
    
    public function setNetAmount(float $netAmount)
    {
        $this->netAmount = $netAmount;
    }
    
    public function getGrossAmount(): float
    {
        return $this->grossAmount;
    }
    
    public function setGrossAmount(float $grossAmount)
    {
        $this->grossAmount = $grossAmount;
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
