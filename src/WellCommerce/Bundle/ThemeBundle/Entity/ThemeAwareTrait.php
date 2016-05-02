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

/**
 * Class ThemeAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ThemeAwareTrait
{
    /**
     * @var ThemeInterface
     */
    protected $theme;
    
    /**
     * @return ThemeInterface
     */
    public function getTheme() : ThemeInterface
    {
        return $this->theme;
    }
    
    /**
     * @param ThemeInterface $theme
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }
}
