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

use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class OrderTotal
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotal implements OrderTotalInterface
{
    /**
     * @var float
     */
    protected $netAmount = 0;
    
    /**
     * @var float
     */
    protected $grossAmount = 0;
    
    /**
     * @var float
     */
    protected $taxAmount = 0;
    
    /**
     * @var float
     */
    protected $taxRate;
    
    /**
     * @var string
     */
    protected $currency;
    
    /**
     * @return float
     */
    public function getNetAmount() : float
    {
        return $this->netAmount;
    }
    
    /**
     * @param float $netAmount
     */
    public function setNetAmount(float $netAmount)
    {
        $this->netAmount = $netAmount;
    }
    
    /**
     * @return float
     */
    public function getGrossAmount() : float
    {
        return $this->grossAmount;
    }
    
    /**
     * @param float $grossAmount
     */
    public function setGrossAmount(float $grossAmount)
    {
        $this->grossAmount = $grossAmount;
    }
    
    /**
     * @return float|int
     */
    public function getTaxAmount() : float
    {
        return $this->taxAmount;
    }
    
    /**
     * @param float $taxAmount
     */
    public function setTaxAmount(float $taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }
    
    /**
     * @return float
     */
    public function getTaxRate() : float
    {
        return (float)$this->taxRate;
    }
    
    /**
     * @param float $taxRate
     */
    public function setTaxRate(float $taxRate)
    {
        $this->taxRate = $taxRate;
    }
    
    /**
     * @return string
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }
    
    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    
    public function recalculate()
    {
        $this->netAmount = TaxHelper::calculateNetPrice($this->grossAmount, $this->taxRate);
        $this->taxAmount = $this->grossAmount - $this->netAmount;
    }
}

