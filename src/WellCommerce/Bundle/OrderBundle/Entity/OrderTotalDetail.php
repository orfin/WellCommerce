<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class OrderTotalDetail
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalDetail extends AbstractEntity implements OrderTotalDetailInterface
{
    use HierarchyAwareTrait;
    use OrderAwareTrait;
    
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
     * @var float
     */
    protected $modifierValue;
    
    /**
     * {@inheritdoc}
     */
    public function getCollector() : string
    {
        return $this->collector;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCollector(string $collector)
    {
        $this->collector = $collector;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrderTotal() : OrderTotal
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
    public function setModifierType(string $modifierType)
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
    public function setModifierValue(float $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isSubtraction() : bool
    {
        return $this->subtraction;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSubtraction(bool $subtraction)
    {
        $this->subtraction = $subtraction;
    }
}
