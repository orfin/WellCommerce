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

namespace WellCommerce\Bundle\LayoutBundle\Locator;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Config\FileLocator as BaseFileLocator;
use WellCommerce\Bundle\LayoutBundle\Theme\ShopTheme;


/**
 * Class FileLocator
 *
 * @package WellCommerce\Bundle\LayoutBundle\Locator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipThemeBundle <https://github.com/liip/LiipThemeBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class FileLocator extends BaseFileLocator
{
    protected $kernel;
    protected $path;
    protected $basePaths = [];
    protected $pathPatterns;
    protected $activeTheme;
    protected $lastTheme = '';
    protected $shopTheme;
    protected $webPath;

    /**
     * Constructor
     *
     * @param KernelInterface $kernel
     * @param null            $path
     * @param array           $paths
     * @param array           $pathPatterns
     */
    public function __construct(KernelInterface $kernel, $path = null, ShopTheme $shopTheme)
    {
        $this->kernel       = $kernel;
        $this->webPath      = $kernel->getRootDir() . '/../web';
        $this->path         = $path;
        $this->shopTheme    = $shopTheme;
        $this->activeTheme  = $this->shopTheme->getCurrentTheme();
        $this->pathPatterns = $this->shopTheme->getPathPatterns();

        $this->setCurrentTheme($this->activeTheme);
    }

    /**
     * Set the active theme.
     *
     * @param string $theme
     */
    public function setCurrentTheme($theme)
    {
        $this->lastTheme = $theme;

        $paths = $this->basePaths;

        $paths[] = $this->path . '/themes/' . $theme;
        $paths[] = $this->path;

        $this->paths = $paths;
    }

    public function locate($name, $dir = null, $first = true)
    {
        // update the paths if the theme changed since the last lookup
        $theme = $this->activeTheme;
        if ($this->lastTheme !== $theme) {
            $this->setCurrentTheme($theme);
        }

        if ('@' === $name[0]) {
            return $this->locateBundleResource($name, $this->path, $first);
        }

//        if (0 === strpos($name, 'views/')) {
//            if ($res = $this->locateAppResource($name, $this->path, $first)) {
//                return $res;
//            }
//        }

        return parent::locate($name, $dir, $first);
    }

    /**
     * Locate Resource Theme aware. Only working for bundle resources!
     *
     * Method inlined from Symfony\Component\Http\Kernel
     *
     * @param string $name
     * @param string $dir
     * @param bool   $first
     *
     * @return string
     */
    protected function locateBundleResource($name, $dir = null, $first = true)
    {
        if (false !== strpos($name, '..')) {
            throw new \RuntimeException(sprintf('File name "%s" contains invalid characters (..).', $name));
        }

        $bundleName = substr($name, 1);
        $path       = '';
        if (false !== strpos($bundleName, '/')) {
            list($bundleName, $path) = explode('/', $bundleName, 2);
        }

        if (0 !== strpos($path, 'Resources')) {
            throw new \RuntimeException('Template files have to be in Resources.');
        }

        $resourceBundle = null;
        $bundles        = $this->kernel->getBundle($bundleName, false);
        $files          = array();

        $parameters = array(
            '%app_path%'      => $this->path,
            '%web_path%'      => $this->webPath,
            '%dir%'           => $dir,
            '%override_path%' => substr($path, strlen('Resources/')),
            '%current_theme%' => $this->lastTheme,
            '%template%'      => substr($path, strlen('Resources/views/')),
        );

        foreach ($bundles as $bundle) {
            $parameters = array_merge($parameters, [
                '%bundle_path%' => $bundle->getPath(),
                '%bundle_name%' => $bundle->getName(),
            ]);

            $checkPaths = $this->getPathsForBundleResource($parameters);

            foreach ($checkPaths as $checkPath) {
                if (file_exists($checkPath)) {
                    if (null !== $resourceBundle) {
                        throw new \RuntimeException(sprintf('"%s" resource is hidden by a resource from the "%s" derived bundle. Create a "%s" file to override the bundle resource.',
                            $path,
                            $resourceBundle,
                            $checkPath
                        ));
                    }

                    if ($first) {
                        return $checkPath;
                    }
                    $files[] = $checkPath;
                }
            }

            $file = $bundle->getPath() . '/' . $path;
            if (file_exists($file)) {
                if ($first) {
                    return $file;
                }
                $files[]        = $file;
                $resourceBundle = $bundle->getName();
            }
        }

        if (count($files) > 0) {
            return $first ? $files[0] : $files;
        }

        throw new \InvalidArgumentException(sprintf('Unable to find file "%s".', $name));
    }

    /**
     * Locate Resource Theme aware. Only working for app/Resources
     *
     * @param string $name
     * @param string $dir
     * @param bool   $first
     *
     * @return string|array
     */
    protected function locateAppResource($name, $dir = null, $first = true)
    {
        if (false !== strpos($name, '..')) {
            throw new \RuntimeException(sprintf('File name "%s" contains invalid characters (..).', $name));
        }

        $files      = [];
        $parameters = [
            '%app_path%'      => $this->path,
            '%current_theme%' => $this->lastTheme,
            '%template%'      => substr($name, strlen('views/')),
        ];

        foreach ($this->getPathsForAppResource($parameters) as $checkPaths) {
            if (file_exists($checkPaths)) {
                if ($first) {
                    return $checkPaths;
                }
                $files[] = $checkPaths;
            }
        }

        return $files;
    }

    protected function getPathsForBundleResource($parameters)
    {
        $pathPatterns = [];
        $paths        = [];

        if (!empty($parameters['%dir%'])) {
            $pathPatterns = array_merge($pathPatterns, $this->pathPatterns['bundle_resource_dir']);
        }

        $pathPatterns = array_merge($pathPatterns, $this->pathPatterns['bundle_resource']);

        foreach ($pathPatterns as $pattern) {
            $paths[] = strtr($pattern, $parameters);
        }

        return $paths;
    }

    protected function getPathsForAppResource($parameters)
    {
        $paths = [];

        foreach ($this->pathPatterns['app_resource'] as $pattern) {
            $paths[] = strtr($pattern, $parameters);
        }

        return $paths;
    }
}