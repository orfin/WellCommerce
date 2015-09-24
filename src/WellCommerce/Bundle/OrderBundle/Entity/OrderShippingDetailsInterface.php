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
 * Interface OrderShippingDetailsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderShippingDetailsInterface
{
    /**
     * @return float
     */
    public function getNetPrice();

    /**
     * @param float $netPrice
     */
    public function setNetPrice($netPrice);

    /**
     * @return float
     */
    public function getGrossPrice();

    /**
     * @param float $grossPrice
     */
    public function setGrossPrice($grossPrice);

    /**
     * @return float
     */
    public function getTaxAmount();

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount($taxAmount);

    /**
     * @return float
     */
    public function getTaxRate();

    /**
     * @param float $taxRate
     */
    public function setTaxRate($taxRate);
}
