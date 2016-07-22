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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;

/**
 * Class VariantPrice
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantPrice extends DiscountablePrice
{
    /**
     * @var string
     */
    protected $modifierType = '';

    /**
     * @var float
     */
    protected $modifierValue = 0;

    /**
     * @return string
     */
    public function getModifierType() : string
    {
        return $this->modifierType;
    }

    /**
     * @param string $modifierType
     */
    public function setModifierType(string $modifierType)
    {
        $this->modifierType = $modifierType;
    }

    /**
     * @return float
     */
    public function getModifierValue() : float
    {
        return $this->modifierValue;
    }

    /**
     * @param float $modifierValue
     */
    public function setModifierValue(float $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }
}
