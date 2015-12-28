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
class OrderTotal
{
    /**
     * @var int|float
     */
    protected $netAmount;

    /**
     * @var int|float
     */
    protected $grossAmount;

    /**
     * @var int|float
     */
    protected $taxAmount;

    /**
     * @var int|float
     */
    protected $taxRate;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @return float|int
     */
    public function getNetAmount()
    {
        return $this->netAmount;
    }

    /**
     * @param float|int $netAmount
     */
    public function setNetAmount($netAmount)
    {
        $this->netAmount = $netAmount;
    }

    /**
     * @return float|int
     */
    public function getGrossAmount()
    {
        return (float)$this->grossAmount;
    }

    /**
     * @param float|int $grossAmount
     */
    public function setGrossAmount($grossAmount)
    {
        $this->grossAmount = (float)$grossAmount;
    }

    /**
     * @return float|int
     */
    public function getTaxAmount()
    {
        return (float)$this->taxAmount;
    }

    /**
     * @param float|int $taxAmount
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * @return float|int
     */
    public function getTaxRate()
    {
        return (float)$this->taxRate;
    }

    /**
     * @param float|int $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = (float)$taxRate;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Recalculates the net and tax amount
     *
     * @param int|float $grossAmount
     * @param int|float $taxRate
     */
    public function recalculate()
    {
        $this->netAmount = TaxHelper::calculateNetPrice($this->grossAmount, $this->taxRate);
        $this->taxAmount = $this->grossAmount - $this->netAmount;
    }
}

