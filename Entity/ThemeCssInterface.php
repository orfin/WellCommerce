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

use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;

/**
 * Interface ThemeCssInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeCssInterface extends TimestampableInterface, ThemeAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getAttribute();

    /**
     * @param string $attribute
     */
    public function setAttribute($attribute);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param string $class
     */
    public function setClass($class);

    /**
     * @return string
     */
    public function getSelector();

    /**
     * @param string $selector
     */
    public function setSelector($selector);
}
