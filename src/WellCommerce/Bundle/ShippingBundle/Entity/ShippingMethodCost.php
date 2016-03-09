<?php

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\AppBundle\Entity\Price;

/**
 * Class ShippingMethodCost
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodCost implements ShippingMethodCostInterface
{
    use TimestampableTrait;
    use ShippingMethodAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $rangeFrom;

    /**
     * @var float
     */
    protected $rangeTo;

    /**
     * @var Price
     */
    protected $cost;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getRangeFrom()
    {
        return $this->rangeFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function setRangeFrom($rangeFrom)
    {
        $this->rangeFrom = (float)$rangeFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function getRangeTo()
    {
        return $this->rangeTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setRangeTo($rangeTo)
    {
        $this->rangeTo = (float)$rangeTo;
    }

    /**
     * @return Price
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param Price $cost
     */
    public function setCost(Price $cost)
    {
        $this->cost = $cost;
    }
}
