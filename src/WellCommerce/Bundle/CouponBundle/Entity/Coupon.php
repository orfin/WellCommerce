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
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Coupon
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Coupon extends AbstractEntity implements CouponInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $modifierType;

    /**
     * @var int|float
     */
    protected $modifierValue;

    /**
     * @var \DateTime|null
     */
    protected $validFrom;

    /**
     * @var \DateTime|null
     */
    protected $validTo;

    /**
     * @var int
     */
    protected $clientUsageLimit;

    /**
     * @var int
     */
    protected $globalUsageLimit;

    /**
     * {@inheritdoc}
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierType() : string
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
    public function getModifierValue() : float
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
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function setValidFrom(\DateTime $validFrom = null)
    {
        $this->validFrom = $validFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setValidTo(\DateTime $validTo = null)
    {
        $this->validTo = $validTo;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientUsageLimit() : int
    {
        return $this->clientUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function setClientUsageLimit(int $clientUsageLimit)
    {
        $this->clientUsageLimit = $clientUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobalUsageLimit() : int
    {
        return $this->globalUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function setGlobalUsageLimit(int $globalUsageLimit)
    {
        $this->globalUsageLimit = $globalUsageLimit;
    }
}
