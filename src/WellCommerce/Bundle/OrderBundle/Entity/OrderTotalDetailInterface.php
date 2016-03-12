<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Class OrderTotalDetailInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderTotalDetailInterface extends OrderAwareInterface, HierarchyAwareInterface, EntityInterface
{
    /**
     * @return string
     */
    public function getCollector() : string;

    /**
     * @param string $collector
     */
    public function setCollector(string $collector);

    /**
     * @return OrderTotal
     */
    public function getOrderTotal() : OrderTotal;

    /**
     * @param OrderTotal $orderTotal
     */
    public function setOrderTotal(OrderTotal $orderTotal);

    /**
     * @return string
     */
    public function getModifierType() : string;

    /**
     * @param string $modifierType
     */
    public function setModifierType(string $modifierType);

    /**
     * @return float
     */
    public function getModifierValue() : float;

    /**
     * @param float $modifierValue
     */
    public function setModifierValue(float $modifierValue);

    /**
     * @return bool
     */
    public function isSubtraction() : bool;

    /**
     * @param boolean $subtraction
     */
    public function setSubtraction(bool $subtraction);
}
