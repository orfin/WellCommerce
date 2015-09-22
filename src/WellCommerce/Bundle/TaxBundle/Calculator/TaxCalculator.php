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

namespace WellCommerce\Bundle\TaxBundle\Calculator;

/**
 * Class TaxCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxCalculator implements TaxCalculatorInterface
{
    /**
     * @var int|float
     */
    protected $netPrice = 0;

    /**
     * @var int|float
     */
    protected $grossPrice = 0;

    /**
     * @var int|float
     */
    protected $taxAmount = 0;

    /**
     * @var int|float
     */
    protected $taxRate = 0;

    /**
     * Constructor
     *
     * @param int|float $netPrice
     * @param int|float $taxRate
     */
    public function __construct($netPrice = 0, $taxRate = 0)
    {
        $this->netPrice = floatval($netPrice);
        $this->taxRate  = floatval($taxRate);
    }

    /**
     * {@inheritdoc}
     */
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxAmount()
    {
        return $this->netPrice * ($this->taxRate / 100);
    }

    /**
     * {@inheritdoc}
     */
    public function getGrossPrice()
    {
        return $this->netPrice + $this->getTaxAmount();
    }
}
