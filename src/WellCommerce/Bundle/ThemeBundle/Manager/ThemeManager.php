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

namespace WellCommerce\Bundle\ThemeBundle\Manager;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\Theme;

/**
 * Class ThemeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeManager implements ThemeManagerInterface
{
    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var string
     */
    protected $fallBackTheme;

    /**
     * Constructor
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel        = $kernel;
        $this->fallBackTheme = $this->getFallBackTheme();
    }

    /**
     * @return string|null
     */
    protected function getFallBackTheme()
    {
        if (null !== $this->kernel->getContainer()) {
            return $this->kernel->getContainer()->getParameter('fallback_theme');
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentThemeFolder()
    {
        return (null === $this->theme) ? $this->fallBackTheme : $this->theme->getFolder();
    }

    /**
     * {@inheritdoc}
     */
    public function getThemesDirectory()
    {
        return $this->kernel->getRootDir() . '/../web/themes';
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentTheme(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTheme()
    {
        return $this->theme;
    }

    /**
     * {@inheritdoc}
     */
    public function locateTemplate($name)
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

    /**
     * {@inheritdoc}
     */
    public function getThemePathPattern()
    {
        return '%themes_path%/%current_theme%/templates/%bundle_name%/%template%';

    }

    /**
     * Validates filename
     *
     * @param string $name
     *
     * @return bool
     */
    protected function isValidFilename($name)
    {
        return (false === strpos($name, '..'));
    }

    /**
     * Returns bundle name and path from bundle name
     *
     * @param string $name
     *
     * @return array
     */
    protected function getBundleNameAndPath($name)
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

    /**
     * Processes bundle structure and searches for valid file
     *
     * @param array  $bundles
     * @param array  $parameters
     * @param string $name
     *
     * @return string
     */
    protected function locateBundlesResource(array $bundles, array $parameters, $name)
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

    /**
     * Finds path for bundle theme if exists
     *
     * @param BundleInterface $bundle
     * @param array           $parameters
     */
    protected function locateThemePathForBundleResource(BundleInterface $bundle, array $parameters, &$checkPaths)
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

    /**
     * Locates default bundle template in Resources/views folder
     *
     * @param BundleInterface $bundle
     * @param string          $path
     * @param array           $resourcePaths
     */
    protected function getDefaultBundleResourcePath(BundleInterface $bundle, $path, &$resourcePaths)
    {
        $file = $bundle->getPath() . '/' . $path;
        if ($this->isValidPath($file)) {
            $resourcePaths[] = $file;
        }
    }

    /**
     * Checks whether filename is valid
     *
     * @param string $path
     *
     * @return bool
     */
    protected function isValidPath($path)
    {
        return file_exists($path);
    }
}
