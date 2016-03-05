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
class Price
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
     * @var float
     */
    protected $exchangeRate;

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
        $this->netAmount = (float)$netAmount;
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
        $this->taxAmount = (float)$taxAmount;
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
}
