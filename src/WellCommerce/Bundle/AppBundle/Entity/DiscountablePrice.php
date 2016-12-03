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

use Carbon\Carbon;
use DateTime;

/**
 * Class DiscountablePrice
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DiscountablePrice extends Price
{
    protected $discountedNetAmount   = 0.00;
    protected $discountedGrossAmount = 0.00;
    protected $discountedTaxAmount   = 0.00;
    protected $validFrom             = null;
    protected $validTo               = null;
    
    public function getValidFrom()
    {
        return $this->validFrom;
    }
    
    public function setValidFrom(DateTime $validFrom = null)
    {
        if (null !== $validFrom) {
            $validFrom = $validFrom->setTime(0, 0, 0);
        }
        
        $this->validFrom = $validFrom;
    }
    
    public function getValidTo()
    {
        return $this->validTo;
    }
    
    public function setValidTo(DateTime $validTo = null)
    {
        if (null !== $validTo) {
            $validTo = $validTo->setTime(23, 59, 59);
        }
        
        $this->validTo = $validTo;
    }
    
    public function getFinalGrossAmount(): float
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedGrossAmount();
        }
        
        return $this->getGrossAmount();
    }
    
    public function isDiscountValid(): bool
    {
        $validFrom = ($this->validFrom === null) ? Carbon::now()->startOfDay() : Carbon::instance($this->validFrom)->startOfDay();
        $validTo   = ($this->validTo === null) ? Carbon::now()->endOfDay() : Carbon::instance($this->validTo)->endOfDay();
        
        return $validFrom->isPast() && $validTo->isFuture() && $this->discountedGrossAmount > 0;
    }
    
    public function getDiscountedGrossAmount(): float
    {
        return $this->discountedGrossAmount;
    }
    
    public function setDiscountedGrossAmount(float $discountedGrossAmount)
    {
        $this->discountedGrossAmount = $discountedGrossAmount;
    }
    
    public function getFinalNetAmount(): float
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedNetAmount();
        }
        
        return $this->getNetAmount();
    }
    
    public function getDiscountedNetAmount(): float
    {
        return $this->discountedNetAmount;
    }
    
    public function setDiscountedNetAmount(float $discountedNetAmount)
    {
        $this->discountedNetAmount = $discountedNetAmount;
    }
    
    public function getFinalTaxAmount(): float
    {
        if ($this->isDiscountValid()) {
            return $this->getDiscountedTaxAmount();
        }
        
        return $this->getTaxAmount();
    }
    
    public function getDiscountedTaxAmount(): float
    {
        return $this->discountedTaxAmount;
    }
    
    public function setDiscountedTaxAmount(float $discountedTaxAmount)
    {
        $this->discountedTaxAmount = $discountedTaxAmount;
    }
}
