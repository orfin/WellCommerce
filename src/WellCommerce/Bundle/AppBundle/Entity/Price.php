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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Class Price
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Price implements PriceInterface
{
    protected $netAmount    = 0;
    protected $grossAmount  = 0;
    protected $taxAmount    = 0;
    protected $taxRate      = 0;
    protected $currency     = '';
    protected $exchangeRate = 0;
    
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
    
    public function getTaxRate() : float
    {
        return $this->taxRate;
    }
    
    public function setTaxRate(float $taxRate)
    {
        $this->taxRate = $taxRate;
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
