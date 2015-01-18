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

use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\Theme;
use WellCommerce\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;

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
     * Constructor
     *
     * @param ThemeRepositoryInterface $repository
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function getThemeDirectory(Theme $theme)
    {
        return $this->getThemesDirectory() . DIRECTORY_SEPARATOR . $theme->getFolder();
    }

    /**
     * {@inheritdoc}
     */
    public function getThemesDirectory()
    {
        $kernelDir = $this->kernel->getRootDir();

        return $kernelDir . '/../web/themes';
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
        if (null === $this->theme) {
            throw new \LogicException('Cannot return current Theme object. You forgot to set it before using "setCurrentTheme" method.');
        }

        return $this->theme;
    }

    /**
     * {@inheritdoc}
     */
    public function locateTemplate($name)
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

        $bundles = $this->kernel->getBundle($bundleName, false);

        $parameters = [
            '%themes_path%'   => $this->getThemesDirectory(),
            '%current_theme%' => 'demo',
            '%template%'      => substr($path, strlen('Resources/views/')),
        ];

        foreach ($bundles as $bundle) {
            $parameters = array_merge($parameters, [
                '%bundle_path%' => $bundle->getPath(),
                '%bundle_name%' => $bundle->getName(),
            ]);

            $checkPaths = $this->getPathsForBundleResource($parameters);

            foreach ($checkPaths as $checkPath) {
                if (file_exists($checkPath)) {
                    return $checkPath;
                }
            }

            $file = $bundle->getPath() . '/' . $path;
            if (file_exists($file)) {
                return $file;
            }
        }

        throw new \InvalidArgumentException(sprintf('Unable to find file "%s".', $name));
    }

    protected function getPathsForBundleResource($parameters)
    {
        $paths        = [];
        $pathPatterns = $this->getThemePathPatterns();

        foreach ($pathPatterns as $pattern) {
            $paths[] = strtr($pattern, $parameters);
        }

        return $paths;
    }

    /**
     * {@inheritdoc}
     */
    public function getThemePathPatterns()
    {
        return [
            '%themes_path%/%current_theme%/templates/%bundle_name%/%template%'
        ];
    }
}
