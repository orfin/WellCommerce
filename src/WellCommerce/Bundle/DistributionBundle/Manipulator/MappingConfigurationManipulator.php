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

namespace WellCommerce\Bundle\DistributionBundle\Manipulator;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Class MappingConfigurationManipulator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingConfigurationManipulator extends AbstractContainerAware implements MappingConfigurationManipulatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function modifyMappedServices(MappingCollection $collection, $mappingTargetPath)
    {
        $mappingConfiguration   = $this->getMappingConfiguration();
        $processedConfiguration = [];

        $collection->forAll(function (MappingDefinition $definition) use (&$processedConfiguration, $mappingConfiguration) {
            $extensionConfiguration = $this->processConfiguration($definition, $mappingConfiguration);
            $processedConfiguration = array_replace_recursive($processedConfiguration, $extensionConfiguration);
        });

        $this->dumpConfiguration($processedConfiguration, $mappingTargetPath);
    }

    /**
     * Processes mapping configuration for mapping definition
     *
     * @param MappingDefinition $definition
     * @param array             $mappingConfiguration
     * @param string            $targetPath
     *
     * @return array
     */
    protected function processConfiguration(MappingDefinition $definition, array $mappingConfiguration)
    {
        $shortName              = $definition->getReflectionClass()->getShortName();
        $processedConfiguration = [];

        foreach ($mappingConfiguration as $extensionName => $services) {
            foreach ($services as $serviceRootName => $mapping) {
                if ($mapping['entity'] === $definition->getClassName()) {
                    print_r($serviceRootName);
                    $processedConfiguration[$extensionName]['services'][$serviceRootName]['orm_configuration'] = [
                        'entity'  => $mapping['entity'],
                        'mapping' => sprintf('%s/%s.orm.yml', '%kernel.root_dir%/config/generated/doctrine', $shortName)
                    ];
                }
            }
        }

        return $processedConfiguration;
    }

    /**
     * Dumps the configuration
     *
     * @param array  $configuration
     * @param string $mappingTargetPath
     */
    protected function dumpConfiguration(array $configuration, $mappingTargetPath)
    {
        $filename   = $mappingTargetPath . '/extra_mapping.orm.yml';
        $filesystem = new Filesystem();
        $content    = Yaml::dump($configuration, 6);

        $filesystem->dumpFile($filename, $content);
    }

    /**
     * Returns the configuration for all managed extensions
     *
     * @return array
     */
    protected function getMappingConfiguration()
    {
        $bundles       = $this->getBundles();
        $configuration = [];

        foreach ($bundles as $bundle) {
            $extension = $bundle->getContainerExtension();
            if ($extension instanceof ExtensionInterface) {
                $extensionMappingConfiguration = $this->getExtensionMappingConfiguration($extension);
                if (false !== $extensionMappingConfiguration) {
                    $configuration = array_replace_recursive($configuration, $extensionMappingConfiguration);
                }
            }
        }

        return $configuration;
    }

    /**
     * Returns the extension's mapping configuration or false if it was not found
     *
     * @param ExtensionInterface $extension
     *
     * @return array|bool
     */
    protected function getExtensionMappingConfiguration(ExtensionInterface $extension)
    {
        $extensionReflection = new \ReflectionClass($extension);
        if ($this->getReflectionHelper()->hasConstant($extensionReflection, 'EXTENSION_NAME')) {
            $parameter = $extensionReflection->getConstant('EXTENSION_NAME');
            if ($this->container->hasParameter($parameter)) {
                return $this->extractExtensionMappingConfiguration($parameter);
            }
        }

        return false;
    }

    /**
     * Extracts orm_configuration part for extension or returns false if it was not found
     *
     * @param $parameter
     *
     * @return array|bool
     */
    protected function extractExtensionMappingConfiguration($parameter)
    {
        $configuration = $this->container->getParameter($parameter);

        if (isset($configuration['services'])) {
            foreach ($configuration['services'] as $serviceRootName => $serviceConfiguration) {
                if (isset($serviceConfiguration['orm_configuration'])) {
                    return [
                        $parameter => [
                            $serviceRootName => $serviceConfiguration['orm_configuration']
                        ]
                    ];
                }
            }
        }

        return false;
    }
}
