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
 * Class DiscountablePrice
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DiscountablePriceInterface extends PriceInterface
{
    /**
     * @return \DateTime|null
     */
    public function getValidFrom();

    /**
     * @param \DateTime|null $validFrom
     */
    public function setValidFrom(\DateTime $validFrom = null);

    /**
     * @return \DateTime|null
     */
    public function getValidTo();

    /**
     * @param \DateTime|null $validTo
     */
    public function setValidTo(\DateTime $validTo = null);

    /**
     * @return float
     */
    public function getFinalGrossAmount() : float;

    /**
     * @return bool
     */
    public function isDiscountValid() : bool;

    /**
     * @return float
     */
    public function getDiscountedGrossAmount() : float;

    /**
     * @param float $discountedGrossAmount
     */
    public function setDiscountedGrossAmount(float $discountedGrossAmount);

    /**
     * @return float
     */
    public function getFinalNetAmount() : float;

    /**
     * @return float
     */
    public function getDiscountedNetAmount() : float;

    /**
     * @param float $discountedNetAmount
     */
    public function setDiscountedNetAmount(float $discountedNetAmount);

    /**
     * @return float
     */
    public function getFinalTaxAmount() : float;

    /**
     * @return float
     */
    public function getDiscountedTaxAmount() : float;

    /**
     * @param float $discountedTaxAmount
     */
    public function setDiscountedTaxAmount(float $discountedTaxAmount);
}
