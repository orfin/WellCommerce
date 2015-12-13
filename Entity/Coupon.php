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

/**
 * Class Coupon
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Coupon implements CouponInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var integer
     */
    protected $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
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
    public function setModifierType($modifierType)
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
    public function setModifierValue($modifierValue)
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
    public function getClientUsageLimit()
    {
        return $this->clientUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function setClientUsageLimit($clientUsageLimit)
    {
        $this->clientUsageLimit = $clientUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobalUsageLimit()
    {
        return $this->globalUsageLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function setGlobalUsageLimit($globalUsageLimit)
    {
        $this->globalUsageLimit = $globalUsageLimit;
    }
}
