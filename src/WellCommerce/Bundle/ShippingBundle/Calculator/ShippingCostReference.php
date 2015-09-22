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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

/**
 * Class ShippingCostReference
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingCostReference
{
    /**
     * @var float
     */
    protected $netPrice;

    /**
     * @var float
     */
    protected $grossPrice;

    /**
     * @var float
     */
    protected $taxAmount;

    /**
     * Constructor
     *
     * @param float $netPrice
     * @param float $grossPrice
     * @param float $taxAmount
     */
    public function __construct($netPrice = 0, $grossPrice = 0, $taxAmount = 0)
    {
        $this->netPrice   = $netPrice;
        $this->grossPrice = $grossPrice;
        $this->taxAmount  = $taxAmount;
    }

    /**
     * @return float
     */
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * @return float
     */
    public function getGrossPrice()
    {
        return $this->grossPrice;
    }

    /**
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }
}
