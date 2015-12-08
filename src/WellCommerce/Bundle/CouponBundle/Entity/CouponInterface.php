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

/**
 * Interface CouponInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CouponInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     *
     * @return int
     */
    public function getId();

    /**
     *
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

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
    public function getClientUsageLimit();

    /**
     * @param int $clientUsageLimit
     */
    public function setClientUsageLimit($clientUsageLimit);

    /**
     * @return int
     */
    public function getGlobalUsageLimit();

    /**
     * @param int $globalUsageLimit
     */
    public function setGlobalUsageLimit($globalUsageLimit);
}
