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

namespace WellCommerce\Bundle\LayoutBundle\Context\Front;

use WellCommerce\Bundle\LayoutBundle\Entity\ThemeInterface;

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
    public function getCurrentTheme()
    {
        return $this->currentTheme;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentThemeFolder()
    {
        if ($this->hasCurrentTheme()) {
            return $this->currentTheme->getFolder();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentTheme()
    {
        return $this->currentTheme instanceof ThemeInterface;
    }

}
