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
 * Interface OrderProductTotalsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductTotalsInterface
{
    /**
     * @return float
     */
    public function getQuantity();

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity);

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @param float $weight
     */
    public function setWeight($weight);

    /**
     * @return float
     */
    public function getGrossAmount();

    /**
     * @param float $grossAmount
     */
    public function setGrossAmount($grossAmount);

    /**
     * @return float
     */
    public function getNetAmount();

    /**
     * @param float $netAmount
     */
    public function setNetAmount($netAmount);

    /**
     * @return float
     */
    public function getTaxAmount();

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount($taxAmount);
}
