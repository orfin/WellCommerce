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

namespace WellCommerce\Bundle\UnitBundle\Entity;

/**
 * Class UnitAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait UnitAwareTrait
{
    /**
     * @var UnitInterface
     */
    protected $unit;
    
    /**
     * @return UnitInterface
     */
    public function getUnit() : UnitInterface
    {
        return $this->unit;
    }
    
    /**
     * @param UnitInterface $unit
     */
    public function setUnit(UnitInterface $unit)
    {
        $this->unit = $unit;
    }
}
