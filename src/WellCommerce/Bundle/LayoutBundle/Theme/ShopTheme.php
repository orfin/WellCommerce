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

/**
 * Class ShopTheme
 *
 * @package WellCommerce\Bundle\LayoutBundle\Theme
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopTheme
{
    protected $activeTheme = 'development';
    protected $kernel;
    protected $path;

    public function getCurrentTheme()
    {
        return $this->activeTheme;
    }

    public function setCurrentTheme($activeTheme)
    {
        $this->activeTheme = $activeTheme;
    }

    public function getPathPatterns()
    {
        return [
            'app_resource' => array(
                '%app_path%/themes/%current_theme%/%template%',
                '%app_path%/views/%template%',
            ),
            'bundle_resource' => array(
                '%bundle_path%/Resources/themes/%current_theme%/templates/%template%',
            ),
            'bundle_resource_dir' => array(
                '%dir%/themes/%current_theme%/templates/%bundle_name%/%template%',
                '%dir%/%bundle_name%/%override_path%',
            ),
        ];

    }
} 