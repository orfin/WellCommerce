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

namespace WellCommerce\Bundle\ApiBundle\CacheWarmer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\ApiBundle\Metadata\Loader\SerializationMetadataLoaderInterface;

/**
 * Class SerializationCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationCacheWarmer extends CacheWarmer
{
    /**
     * @var string
     */
    protected $searchDirectoryPattern;

    /**
     * SerializationCacheWarmer constructor.
     *
     * @param $searchDirectoryPattern
     */
    public function __construct($searchDirectoryPattern)
    {
        $this->searchDirectoryPattern = $searchDirectoryPattern;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $configuration = $this->getConfiguration();

        if (count($configuration)) {
            $file = $cacheDir . '/' . SerializationMetadataLoaderInterface::CACHE_FILENAME;
            $this->writeCacheFile($file, sprintf('<?php return %s;', var_export($configuration, true)));
        }
    }

    /**
     * @return array
     */
    protected function getConfiguration()
    {
        $configuration = [];
        $finder        = new Finder();
        $finder->in($this->searchDirectoryPattern);
        $finder->name(SerializationMetadataLoaderInterface::MAPPING_FILENAME);

        foreach ($finder->files() as $file) {
            $this->appendConfigurationFromFile($file, $configuration);
        }

        return $configuration;
    }

    /**
     * Appends configuration from file to an array
     *
     * @param SplFileInfo $fileInfo
     * @param array       $configuration
     */
    private function appendConfigurationFromFile(SplFileInfo $fileInfo, array &$configuration = [])
    {
        $configuration = array_replace_recursive($configuration, $this->parseContent($fileInfo->getContents()));
    }

    /**
     * Parses the Yaml contents
     *
     * @param string $content
     *
     * @return array
     */
    private function parseContent($content)
    {
        return Yaml::parse($content);
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * @return Boolean always true
     */
    public function isOptional()
    {
        return false;
    }
}
