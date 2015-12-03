<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;

/**
 * Class OrderTotalDetail
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalDetail implements OrderTotalDetailInterface
{
    use HierarchyAwareTrait;
    use OrderAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $collector;

    /**
     * @var OrderTotal
     */
    protected $orderTotal;

    /**
     * @var bool
     */
    protected $subtraction;

    /**
     * @var string
     */
    protected $modifierType;

    /**
     * @var int|float
     */
    protected $modifierValue;

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
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * {@inheritdoc}
     */
    public function setCollector($collector)
    {
        $this->collector = $collector;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderTotal()
    {
        return $this->orderTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderTotal(OrderTotal $orderTotal)
    {
        $this->orderTotal = $orderTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierType()
    {
        return $this->modifierType;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifierType($modifierType)
    {
        $this->modifierType = $modifierType;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierValue()
    {
        return $this->modifierValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifierValue($modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }

    /**
     * {@inheritdoc}
     */
    public function isSubtraction()
    {
        return $this->subtraction;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubtraction($subtraction)
    {
        $this->subtraction = $subtraction;
    }
}
