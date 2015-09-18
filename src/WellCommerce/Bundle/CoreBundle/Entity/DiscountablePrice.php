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

namespace WellCommerce\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DiscountablePrice
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DiscountablePrice extends Price
{
    /**
     * @var float
     */
    protected $discountedAmount;

    /**
     * @var \DateTime|null
     */
    protected $validFrom;

    /**
     * @var \DateTime|null
     */
    protected $validTo;

    /**
     * @return float
     */
    public function getDiscountedAmount()
    {
        return $this->discountedAmount;
    }

    /**
     * @param float $discountedAmount
     */
    public function setDiscountedAmount($discountedAmount)
    {
        $this->discountedAmount = (float)$discountedAmount;
    }

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
     * @return float
     */
    public function getAmount()
    {
        if ($this->isDiscountDateValid()) {
            return $this->discountedAmount;
        }

        return $this->amount;
    }

    /**
     * @return bool
     */
    protected function isDiscountDateValid()
    {
        $now = new \DateTime();

        if ($this->validFrom instanceof \DateTime && $this->validTo instanceof \DateTime) {
            return ($this->validFrom <= $now) && ($this->validTo >= $now);
        }

        return false;
    }
}
