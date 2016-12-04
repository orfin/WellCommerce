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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface CouponInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CouponInterface extends EntityInterface, TranslatableInterface, TimestampableInterface, BlameableInterface
{
    public function getCode() : string;
    
    public function setCode(string $code);

    public function getCurrency() : string;
    
    public function setCurrency(string $currency);
    
    public function getModifierType() : string;
    
    public function setModifierType(string $modifierType);
    
    public function getModifierValue() : float;
    
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
    
    public function getClientUsageLimit() : int;
    
    public function setClientUsageLimit(int $clientUsageLimit);
    
    public function getGlobalUsageLimit() : int;
    
    public function setGlobalUsageLimit(int $globalUsageLimit);

    public function getMinimumOrderValue(): float;

    public function setMinimumOrderValue(float $minimumOrderValue);
    
    public function isExcludePromotions(): bool;
    
    public function setExcludePromotions(bool $excludePromotions);
}
