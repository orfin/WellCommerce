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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AppKernel
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles           = [];
        $bundlesToRegister = $this->parseBundleConfig();

        foreach ($bundlesToRegister as $bundle) {
            $bundles[] = new $bundle;
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * @return array
     */
    protected function parseBundleConfig()
    {
        $configurationFile = $this->getRootDir() . '/config/bundles.yml';
        $configuration     = Yaml::parse(file_get_contents($configurationFile));
        $environment       = $this->getEnvironment();
        $bundlesToRegister = $configuration['_main'];

        if (in_array($environment, ['dev', 'test']) && isset($configuration[$environment])) {
            $bundlesToRegister = array_merge($bundlesToRegister, $configuration[$environment]);
        }

        return $bundlesToRegister;
    }
}
