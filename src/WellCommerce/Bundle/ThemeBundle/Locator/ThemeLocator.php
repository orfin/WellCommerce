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

namespace WellCommerce\Bundle\ThemeBundle\Locator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\ThemeBundle\Context\Front\ThemeContextInterface;

/**
 * Class ThemeLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ThemeLocator implements ThemeLocatorInterface
{
    /**
     * @var ThemeContextInterface
     */
    private $themeContext;
    
    /**
     * @var KernelInterface
     */
    private $kernel;
    
    /**
     * @var string
     */
    private $fallBackTheme;
    
    /**
     * @var string
     */
    private $themesDir;
    
    /**
     * @var array
     */
    private $themeFolders = [];
    
    /**
     * ThemeLocator constructor.
     *
     * @param KernelInterface       $kernel
     * @param ThemeContextInterface $themeContext
     * @param string                $fallbackTheme
     * @param string                $themesDir
     */
    public function __construct(KernelInterface $kernel, ThemeContextInterface $themeContext, string $fallbackTheme, string $themesDir)
    {
        $this->kernel        = $kernel;
        $this->fallBackTheme = $fallbackTheme;
        $this->themeContext  = $themeContext;
        $this->themesDir     = $themesDir;
    }
    
    public function getCurrentThemeFolder() : string
    {
        if (false === $this->themeContext->hasCurrentTheme()) {
            return $this->fallBackTheme;
        }
        
        return $this->themeContext->getCurrentThemeFolder();
    }
    
    public function getThemesDirectory() : string
    {
        return $this->themesDir;
    }
    
    public function getThemeFolders() : array
    {
        if (empty($this->themeFolders)) {
            $this->themeFolders = $this->scanThemesDirectory();
        }
        
        return $this->themeFolders;
    }
    
    public function locateTemplate(string $name) : string
    {
        if (!$this->isValidFilename($name)) {
            throw new \RuntimeException(sprintf('File name "%s" contains invalid characters (..).', $name));
        }
        
        list($bundleName, $path) = $this->getBundleNameAndPath($name);
        
        if (0 !== strpos($path, 'Resources')) {
            throw new \RuntimeException('Template files have to be in Resources.');
        }
        
        $bundles = $this->kernel->getBundle($bundleName, false);
        
        $parameters = [
            '%themes_path%'   => $this->getThemesDirectory(),
            '%current_theme%' => $this->getCurrentThemeFolder(),
            '%template%'      => substr($path, strlen('Resources/views/')),
        ];
        
        return $this->locateBundlesResource($bundles, $parameters, $path);
    }
    
    public function getThemePathPattern() : string
    {
        return '%themes_path%/%current_theme%/templates/%bundle_name%/%template%';
        
    }
    
    private function getBundleNameAndPath(string $name) : array
    {
        $bundleName = substr($name, 1);
        $path       = '';
        
        if (false !== strpos($bundleName, '/')) {
            list($bundleName, $path) = explode('/', $bundleName, 2);
        }
        
        return [
            $bundleName,
            $path
        ];
    }
    
    protected function locateBundlesResource(array $bundles, array $parameters, string $name) : string
    {
        $themePaths    = [];
        $resourcePaths = [];
        
        foreach ($bundles as $bundle) {
            $this->locateThemePathForBundleResource($bundle, $parameters, $themePaths);
            $this->getDefaultBundleResourcePath($bundle, $name, $resourcePaths);
        }
        
        $paths = array_merge($themePaths, $resourcePaths);
        
        if (count($paths)) {
            return current($paths);
        }
        
        throw new \InvalidArgumentException(sprintf('Unable to find file "%s".', $name));
    }
    
    private function locateThemePathForBundleResource(BundleInterface $bundle, array $parameters, array &$checkPaths)
    {
        $pathPattern = $this->getThemePathPattern();
        $parameters  = array_merge($parameters, [
            '%bundle_path%' => $bundle->getPath(),
            '%bundle_name%' => $bundle->getName(),
        ]);
        
        $path = strtr($pathPattern, $parameters);
        
        if ($this->isValidPath($path)) {
            $checkPaths[] = $path;
        }
    }
    
    private function getDefaultBundleResourcePath(BundleInterface $bundle, string $path, array &$resourcePaths)
    {
        $file = $bundle->getPath() . '/' . $path;
        if ($this->isValidPath($file)) {
            $resourcePaths[] = $file;
        }
    }
    
    private function isValidPath(string $path) : bool
    {
        return file_exists($path);
    }
    
    private function isValidFilename(string $name) : bool
    {
        return (false === strpos($name, '..'));
    }
    
    private function scanThemesDirectory() : array
    {
        $folders     = [];
        $finder      = new Finder();
        $directories = $finder->directories()->in($this->themesDir)->sortByName()->depth('== 1');
        
        foreach ($directories as $directory) {
            $name           = $directory->getRelativePath();
            $folders[$name] = $name;
        }
        
        return $folders;
    }
}
