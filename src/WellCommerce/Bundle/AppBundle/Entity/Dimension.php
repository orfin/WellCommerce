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
    protected $depth = 0;
    protected $width = 0;
    protected $height = 0;
    
    /**
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }
    
    /**
     * @param float $depth
     */
    public function setDepth($depth)
    {
        $this->depth = (float)$depth;
    }
    
    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = (float)$width;
    }
    
    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = (float)$height;
    }
}
