<?php

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;

/**
 * Class ShippingMethodCost
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="shipping_method_cost")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodCostRepository")
 */
class ShippingMethodCost
{
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod", inversedBy="costs")
     * @ORM\JoinColumn(name="shipping_method_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $shippingMethod;

    /**
     * @var float
     *
     * @ORM\Column(name="range_from", type="decimal", precision=15, scale=4)
     */
    protected $rangeFrom;

    /**
     * @var float
     *
     * @ORM\Column(name="range_to", type="decimal", precision=15, scale=4)
     */
    protected $rangeTo;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="decimal", precision=15, scale=4)
     */
    protected $cost;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ShippingMethod
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param ShippingMethod $shippingMethod
     */
    public function setShippingMethod(ShippingMethod $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return float
     */
    public function getRangeFrom()
    {
        return $this->rangeFrom;
    }

    /**
     * @param float $rangeFrom
     */
    public function setRangeFrom($rangeFrom)
    {
        $this->rangeFrom = $rangeFrom;
    }

    /**
     * @return float
     */
    public function getRangeTo()
    {
        return $this->rangeTo;
    }

    /**
     * @param float $rangeTo
     */
    public function setRangeTo($rangeTo)
    {
        $this->rangeTo = $rangeTo;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }
}
