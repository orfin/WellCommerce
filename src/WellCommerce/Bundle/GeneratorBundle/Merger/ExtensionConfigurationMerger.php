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

namespace WellCommerce\Bundle\GeneratorBundle\Merger;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\GeneratorBundle\Dumper\YamlDumper;
use WellCommerce\Bundle\GeneratorBundle\Reflection\ClassAnalyzer;
use Wingu\OctopusCore\Reflection\ReflectionClass;

/**
 * Class YamlConfigurationMerger
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtensionConfigurationMerger extends AbstractContainerAware implements MergerInterface
{
    const CONFIGURATION_FILE_NAME    = 'wellcommerce.yml';
    const CONFIGURATION_PATH_PATTERN = 'src/*/*/*/Resources/config';

    public function merge()
    {
        $extensions    = $this->getManagedExtensions();
        $configuration = $this->getExtensionsConfiguration($extensions);

        $this->dumpConfiguration('extensions.yml', $configuration);
    }

    protected function dumpConfiguration($file, array $configuration = [])
    {
        $dumper = new YamlDumper();
        $dumper->dump($this->getConfigTargetDir($file), $configuration);
    }

    /**
     * Returns all managed extensions
     *
     * @return array
     */
    protected function getManagedExtensions()
    {
        $classAnalyzer = new ClassAnalyzer();
        $bundles       = $this->getBundles();
        $extensions    = [];

        foreach ($bundles as $bundle) {
            $extension = $bundle->getContainerExtension();
            if ($extension instanceof ExtensionInterface) {
                $extensionReflection = new ReflectionClass($extension);
                if ($classAnalyzer->hasConstant($extensionReflection, 'EXTENSION_NAME')) {
                    $extensions[] = $extensionReflection->getConstant('EXTENSION_NAME');
                }
            }
        }

        return $extensions;
    }

    /**
     * Returns merged extensions configuration as an array
     *
     * @param array $extensions
     *
     * @return array
     */
    protected function getExtensionsConfiguration(array $extensions = [])
    {
        $configuration = [];
        $finder        = new Finder();
        $finder->name(self::CONFIGURATION_FILE_NAME);

        foreach ($finder->in(self::CONFIGURATION_PATH_PATTERN) as $file) {
            $extensionConfiguration = $this->parseConfigFile($file);
            if (is_array($extensionConfiguration)) {
                $extensionTreeRoot = current(array_keys($extensionConfiguration));
                if (in_array($extensionTreeRoot, $extensions)) {
                    $configuration = array_replace_recursive($configuration, $extensionConfiguration);
                }
            }
        }

        return $configuration;
    }

    /**
     * @return string
     */
    protected function getConfigTargetDir($file)
    {
        return $this->getConfigDir() . '/generated/' . $file;
    }

    /**
     * Parses the config file
     *
     * @param \SplFileInfo $file
     *
     * @return array
     */
    private function parseConfigFile(\SplFileInfo $file)
    {
        return Yaml::parse($file->getContents());
    }
}
