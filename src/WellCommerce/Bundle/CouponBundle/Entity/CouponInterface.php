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

namespace WellCommerce\Bundle\CouponBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;

/**
 * Interface CouponInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CouponInterface extends IdentifiableEntityInterface, TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getCode() : string;

    /**
     * @param string $code
     */
    public function setCode(string $code);

    /**
     * @return string
     */
    public function getCurrency() : string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency);

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
     * @return \DateTime|null
     */
    public function getValidFrom();

    /**
     * @param \DateTime|null $validFrom
     */
    public function setValidFrom(\DateTime $validFrom = null);

    /**
     * @return \DateTime|null
     */
    public function getValidTo();

    /**
     * @param \DateTime|null $validTo
     */
    public function setValidTo(\DateTime $validTo = null);

    /**
     * @return int
     */
    public function getClientUsageLimit() : int;

    /**
     * @param int $clientUsageLimit
     */
    public function setClientUsageLimit(int $clientUsageLimit);

    /**
     * @return int
     */
    public function getGlobalUsageLimit() : int;

    /**
     * @param int $globalUsageLimit
     */
    public function setGlobalUsageLimit(int $globalUsageLimit);
}
