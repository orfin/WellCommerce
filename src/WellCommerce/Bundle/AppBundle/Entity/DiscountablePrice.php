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
class DiscountablePrice extends Price
{
    /**
     * @var int|float
     */
    protected $discountedNetAmount;

    /**
     * @var int|float
     */
    protected $discountedGrossAmount;

    /**
     * @var int|float
     */
    protected $discountedTaxAmount;

    /**
     * @var \DateTime|null
     */
    protected $validFrom;

    /**
     * @var \DateTime|null
     */
    protected $validTo;

    /**
     * @return \DateTime|null
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * @param \DateTime|null $validFrom
     */
    public function setValidFrom(\DateTime $validFrom = null)
    {
        $this->validFrom = $validFrom;
    }

    /**
     * @return \DateTime|null
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * @param \DateTime|null $validTo
     */
    public function setValidTo(\DateTime $validTo = null)
    {
        $this->validTo = $validTo;
    }

    /**
     * @return float|int
     */
    public function getFinalGrossAmount()
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedGrossAmount();
        }

        return $this->getGrossAmount();
    }

    /**
     * @return bool
     */
    public function isDiscountValid()
    {
        $now = new \DateTime();

        if ($this->validFrom instanceof \DateTime && $this->validTo instanceof \DateTime) {
            return ($this->validFrom <= $now) && ($this->validTo >= $now);
        }

        return false;
    }

    /**
     * @return float|int
     */
    public function getDiscountedGrossAmount()
    {
        return (float)$this->discountedGrossAmount;
    }

    /**
     * @param float|int $discountedGrossAmount
     */
    public function setDiscountedGrossAmount($discountedGrossAmount)
    {
        $this->discountedGrossAmount = (float)$discountedGrossAmount;
    }

    /**
     * @return float|int
     */
    public function getFinalNetAmount()
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedNetAmount();
        }

        return $this->getNetAmount();
    }

    /**
     * @return float|int
     */
    public function getDiscountedNetAmount()
    {
        return (float)$this->discountedNetAmount;
    }

    /**
     * @param float|int $discountedNetAmount
     */
    public function setDiscountedNetAmount($discountedNetAmount)
    {
        $this->discountedNetAmount = (float)$discountedNetAmount;
    }

    /**
     * @return float|int
     */
    public function getFinalTaxAmount()
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedTaxAmount();
        }

        return $this->getTaxAmount();
    }

    /**
     * @return float|int
     */
    public function getDiscountedTaxAmount()
    {
        return (float)$this->discountedTaxAmount;
    }

    /**
     * @param float|int $discountedTaxAmount
     */
    public function setDiscountedTaxAmount($discountedTaxAmount)
    {
        $this->discountedTaxAmount = (float)$discountedTaxAmount;
    }
}
