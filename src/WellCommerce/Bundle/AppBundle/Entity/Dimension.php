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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Class Dimension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Dimension
{
    protected $depth  = 1.0000;
    protected $width  = 1.0000;
    protected $height = 1.0000;
    
    public function getDepth(): float
    {
        return $this->depth;
    }
    
    public function setDepth(float $depth)
    {
        $this->depth = $depth;
    }
    
    public function getWidth(): float
    {
        return $this->width;
    }
    
    public function setWidth(float $width)
    {
        $this->width = $width;
    }
    
    public function getHeight(): float
    {
        return $this->height;
    }
    
    public function setHeight(float $height)
    {
        $this->height = $height;
    }
}
