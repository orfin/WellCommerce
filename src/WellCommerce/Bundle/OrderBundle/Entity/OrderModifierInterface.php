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

namespace WellCommerce\Bundle\OrderBundle\Entity;

/**
 * Interface OrderModifierInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderModifierInterface extends OrderAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getNetValue();

    /**
     * @param float $netValue
     */
    public function setNetValue($netValue);

    /**
     * @return float
     */
    public function getTaxValue();

    /**
     * @param float $taxValue
     */
    public function setTaxValue($taxValue);

    /**
     * @return float
     */
    public function getGrossValue();

    /**
     * @param float $grossValue
     */
    public function setGrossValue($grossValue);

    /**
     * @return bool
     */
    public function isIncrease();

    /**
     * @param bool $increase
     */
    public function setIncrease($increase);

    /**
     * @return OrderModifierDetailsInterface
     */
    public function getModifierDetails();

    /**
     * @param OrderModifierDetailsInterface $modifierDetails
     */
    public function setModifierDetails(OrderModifierDetailsInterface $modifierDetails);
}
