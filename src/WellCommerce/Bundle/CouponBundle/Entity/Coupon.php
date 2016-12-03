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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Coupon
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Coupon implements CouponInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    
    protected $code              = '';
    protected $currency          = '';
    protected $modifierType      = '%';
    protected $modifierValue     = 0.00;
    protected $clientUsageLimit  = 1;
    protected $globalUsageLimit  = 1;
    protected $minimumOrderValue = 1;
    protected $excludePromotions = true;
    
    /**
     * @var \DateTime|null
     */
    protected $validFrom;
    
    /**
     * @var \DateTime|null
     */
    protected $validTo;
    
    public function __construct()
    {
        $this->code = strtoupper(uniqid());
    }
    
    public function getCode(): string
    {
        return $this->code;
    }
    
    public function setCode(string $code)
    {
        $this->code = $code;
    }
    
    public function getCurrency(): string
    {
        return $this->currency;
    }
    
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    
    public function getModifierType(): string
    {
        return $this->modifierType;
    }
    
    public function setModifierType(string $modifierType)
    {
        $this->modifierType = $modifierType;
    }
    
    public function getModifierValue(): float
    {
        return $this->modifierValue;
    }
    
    public function setModifierValue(float $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }
    
    public function getValidFrom()
    {
        return $this->validFrom;
    }
    
    public function setValidFrom(\DateTime $validFrom = null)
    {
        $this->validFrom = $validFrom;
    }
    
    public function getValidTo()
    {
        return $this->validTo;
    }
    
    public function setValidTo(\DateTime $validTo = null)
    {
        $this->validTo = $validTo;
    }
    
    public function getClientUsageLimit(): int
    {
        return $this->clientUsageLimit;
    }
    
    public function setClientUsageLimit(int $clientUsageLimit)
    {
        $this->clientUsageLimit = $clientUsageLimit;
    }
    
    public function getGlobalUsageLimit(): int
    {
        return $this->globalUsageLimit;
    }
    
    public function setGlobalUsageLimit(int $globalUsageLimit)
    {
        $this->globalUsageLimit = $globalUsageLimit;
    }
    
    public function getMinimumOrderValue(): float
    {
        return $this->minimumOrderValue;
    }
    
    public function setMinimumOrderValue(float $minimumOrderValue)
    {
        $this->minimumOrderValue = $minimumOrderValue;
    }
    
    public function isExcludePromotions(): bool
    {
        return $this->excludePromotions;
    }
    
    public function setExcludePromotions(bool $excludePromotions)
    {
        $this->excludePromotions = $excludePromotions;
    }
}
