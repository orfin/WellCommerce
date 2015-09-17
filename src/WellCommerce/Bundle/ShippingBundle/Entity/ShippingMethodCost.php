<?php

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;

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
     * @var float
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
     * {@inheritdoc}
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * {@inheritdoc}
     */
    public function setCost($cost)
    {
        $this->cost = (float)$cost;
    }
}
