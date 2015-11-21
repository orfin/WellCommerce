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

namespace WellCommerce\LayoutBundle\Context\Front;

use WellCommerce\LayoutBundle\Entity\ThemeInterface;

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
     * @return null|ThemeInterface
     */
    public function getCurrentTheme();

    /**
     * @return null|string
     */
    public function getCurrentThemeFolder();

    /**
     * @return bool
     */
    public function hasCurrentTheme();
}
