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

namespace WellCommerce\CatalogBundle\Entity;

use WellCommerce\CoreBundle\Entity\DiscountablePrice;

/**
 * Class ProductAttributePrice
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributePrice extends DiscountablePrice
{
    /**
     * @var string
     */
    protected $modifierType;

    /**
     * @var int|float
     */
    protected $modifierValue;

    /**
     * @return string
     */
    public function getModifierType()
    {
        return $this->modifierType;
    }

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType)
    {
        $this->modifierType = $modifierType;
    }

    /**
     * @return float|int
     */
    public function getModifierValue()
    {
        return $this->modifierValue;
    }

    /**
     * @param float|int $modifierValue
     */
    public function setModifierValue($modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }
}
