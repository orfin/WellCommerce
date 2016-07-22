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
    
    public function getUnit()
    {
        return $this->unit;
    }
    
    public function setUnit(UnitInterface $unit = null)
    {
        $this->unit = $unit;
    }
    
    public function hasUnit() : bool
    {
        return $this->unit instanceof UnitInterface;
    }
}
