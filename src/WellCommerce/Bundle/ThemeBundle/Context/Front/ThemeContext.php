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
 * Class ThemeContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeContext implements ThemeContextInterface
{
    /**
     * @var ThemeInterface
     */
    protected $currentTheme;

    /**
     * {@inheritdoc}
     */
    public function setCurrentTheme(ThemeInterface $theme)
    {
        $this->currentTheme = $theme;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTheme() : ThemeInterface
    {
        return $this->currentTheme;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentThemeFolder() : string
    {
        return $this->currentTheme->getFolder();
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentTheme() : bool
    {
        return $this->currentTheme instanceof ThemeInterface;
    }

}
