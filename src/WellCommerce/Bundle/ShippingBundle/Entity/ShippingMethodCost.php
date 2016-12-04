<?php

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class ShippingMethodCost
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodCost implements ShippingMethodCostInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use ShippingMethodAwareTrait;
    
    protected $rangeFrom = 0.00;
    protected $rangeTo   = 0.00;
    
    /**
     * @var Price
     */
    protected $cost;
    
    public function __construct()
    {
        $this->cost = new Price();
    }
    
    public function getRangeFrom(): float
    {
        return $this->rangeFrom;
    }

    public function setRangeFrom(float $rangeFrom)
    {
        $this->rangeFrom = (float)$rangeFrom;
    }

    public function getRangeTo(): float
    {
        return $this->rangeTo;
    }
    
    public function setRangeTo(float $rangeTo)
    {
        $this->rangeTo = (float)$rangeTo;
    }
    
    public function getCost(): Price
    {
        return $this->cost;
    }
    
    public function setCost(Price $cost)
    {
        $this->cost = $cost;
    }
}
