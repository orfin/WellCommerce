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

namespace WellCommerce\Bundle\LayoutBundle\Theme;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;

/**
 * Class ShopTheme
 *
 * @package WellCommerce\Bundle\LayoutBundle\Theme
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopTheme
{
    protected $folder = 'demo';

    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @return LayoutTheme
     */
    public function getCurrentTheme()
    {
        return $this->activeTheme->getFolder();
    }

    public function setCurrentTheme(LayoutTheme $theme)
    {
        $this->activeTheme = $theme;
    }

    public function getPathPatterns()
    {
        return [
            'bundle_resource'     => [
                '%bundle_path%/Resources/themes/%current_theme%/templates/%template%',
                '%web_path%/themes/%current_theme%/templates/%template%',
            ],
            'bundle_resource_dir' => [
                '%dir%/themes/%current_theme%/templates/%bundle_name%/%template%',
                '%web_path%/themes/%current_theme%/templates/%bundle_name%/%template%',
                '%dir%/%bundle_name%/%override_path%',
            ],
        ];
    }
} 