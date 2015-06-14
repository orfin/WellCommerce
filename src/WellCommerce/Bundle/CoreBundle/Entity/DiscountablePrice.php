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
 * @ORM\Embeddable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DiscountablePrice extends Price
{
    /**
     * @ORM\Column(name="discounted_amount", type="decimal", precision=15, scale=4, nullable=true)
     */
    protected $discountedAmount;

    /**
     * @ORM\Column(name="valid_from", type="datetime", nullable=false)
     */
    protected $validFrom;

    /**
     * @ORM\Column(name="valid_to", type="datetime", nullable=false)
     */
    protected $validTo;

    /**
     * @return mixed
     */
    public function getDiscountedAmount()
    {
        return $this->discountedAmount;
    }

    /**
     * @param mixed $discountedAmount
     */
    public function setDiscountedAmount($discountedAmount)
    {
        $this->discountedAmount = $discountedAmount;
    }

    /**
     * @return mixed
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * @param mixed $validFrom
     */
    public function setValidFrom($validFrom)
    {
        $this->validFrom = $validFrom;
    }

    /**
     * @return mixed
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * @param mixed $validTo
     */
    public function setValidTo($validTo)
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

    protected function isDiscountDateValid()
    {
        $now = new \DateTime();

        if ($this->validFrom instanceof \DateTime && $this->validTo instanceof \DateTime) {
            return ($this->validFrom <= $now) && ($this->validTo >= $now);
        }

        return false;
    }
}
