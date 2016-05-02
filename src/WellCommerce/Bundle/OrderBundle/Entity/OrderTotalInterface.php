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
 * Class OrderTotalInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderTotalInterface
{
    /**
     * @return float
     */
    public function getNetAmount() : float;
    
    /**
     * @param float $netAmount
     */
    public function setNetAmount(float $netAmount);
    
    /**
     * @return float
     */
    public function getGrossAmount() : float;
    
    /**
     * @param float $grossAmount
     */
    public function setGrossAmount(float $grossAmount);
    
    /**
     * @return float|int
     */
    public function getTaxAmount() : float;
    
    /**
     * @param float $taxAmount
     */
    public function setTaxAmount(float $taxAmount);
    
    /**
     * @return float
     */
    public function getTaxRate() : float;
    
    /**
     * @param float $taxRate
     */
    public function setTaxRate(float $taxRate);
    
    /**
     * @return string
     */
    public function getCurrency() : string;
    
    /**
     * @param string $currency
     */
    public function setCurrency(string $currency);
    
    public function recalculate();
}

