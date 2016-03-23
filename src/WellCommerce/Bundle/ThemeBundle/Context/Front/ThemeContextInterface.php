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

namespace WellCommerce\Bundle\ThemeBundle\Context\Front;

use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Interface ThemeContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeContextInterface
{
    /**
     * @param ThemeInterface $theme
     */
    public function setCurrentTheme(ThemeInterface $theme);

    /**
     * @return ThemeInterface
     */
    public function getCurrentTheme() : ThemeInterface;

    /**
     * @return string
     */
    public function getCurrentThemeFolder() : string;

    /**
     * @return bool
     */
    public function hasCurrentTheme() : bool;
}
