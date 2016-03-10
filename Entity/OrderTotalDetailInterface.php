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
    public function getCollector();

    /**
     * @param string $collector
     */
    public function setCollector($collector);

    /**
     * @return OrderTotal
     */
    public function getOrderTotal();

    /**
     * @param OrderTotal $orderTotal
     */
    public function setOrderTotal(OrderTotal $orderTotal);

    /**
     * @return string
     */
    public function getModifierType();

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType);

    /**
     * @return float|int
     */
    public function getModifierValue();

    /**
     * @param float|int $modifierValue
     */
    public function setModifierValue($modifierValue);

    /**
     * @return boolean
     */
    public function isSubtraction();

    /**
     * @param boolean $subtraction
     */
    public function setSubtraction($subtraction);
}
