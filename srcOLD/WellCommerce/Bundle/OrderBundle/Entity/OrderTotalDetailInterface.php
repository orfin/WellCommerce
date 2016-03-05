<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

/**
 * Class OrderTotalDetailInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderTotalDetailInterface extends OrderAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getHierarchy();

    /**
     * @param int $hierarchy
     */
    public function setHierarchy($hierarchy);

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
