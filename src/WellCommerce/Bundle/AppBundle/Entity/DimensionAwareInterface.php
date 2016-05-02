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
 * Interface DimensionAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DimensionAwareInterface
{
    /**
     * @return float
     */
    public function getDepth();
    
    /**
     * @param float $depth
     */
    public function setDepth($depth);
    
    /**
     * @return float
     */
    public function getWidth();
    
    /**
     * @param float $width
     */
    public function setWidth($width);
    
    /**
     * @return float
     */
    public function getHeight();
    
    /**
     * @param float $height
     */
    public function setHeight($height);
}
