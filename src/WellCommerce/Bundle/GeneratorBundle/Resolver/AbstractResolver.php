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

namespace WellCommerce\Bundle\GeneratorBundle\Resolver;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class AbstractResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractResolver extends AbstractContainerAware
{
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
     * Parses the config file
     *
     * @param \SplFileInfo $file
     *
     * @return array
     */
    protected function parseFile(\SplFileInfo $file)
    {
        return Yaml::parse($file->getContents());
    }
}
