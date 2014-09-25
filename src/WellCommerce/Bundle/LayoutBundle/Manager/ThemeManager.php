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

namespace WellCommerce\Bundle\LayoutBundle\Manager;

use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;
use WellCommerce\Bundle\LayoutBundle\Manager\Box\LayoutBoxCollection;

/**
 * Class ThemeManager
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeManager
{
    /**
     * @var LayoutTheme
     */
    protected $theme;

    protected $boxes;

    public function __construct()
    {
        $this->boxes = new LayoutBoxCollection();
    }

    public function getCurrentTheme()
    {
        return $this->theme;
    }

    public function setCurrentTheme(LayoutTheme $theme)
    {
        $this->theme = $theme;
    }

    public function getBoxes()
    {
        return $this->theme->getBoxes();
    }

    public function getBox($identifier)
    {
        $this->theme->getBoxes();
    }
} 