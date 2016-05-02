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

namespace WellCommerce\Bundle\ThemeBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface ThemeCssInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeCssInterface extends EntityInterface, TimestampableInterface, ThemeAwareInterface
{
    /**
     * @return string
     */
    public function getAttribute() : string;
    
    /**
     * @param string $attribute
     */
    public function setAttribute(string $attribute);
    
    /**
     * @return string
     */
    public function getClass() : string;
    
    /**
     * @param string $class
     */
    public function setClass(string $class);
    
    /**
     * @return string
     */
    public function getSelector() : string;
    
    /**
     * @param string $selector
     */
    public function setSelector(string $selector);
}
