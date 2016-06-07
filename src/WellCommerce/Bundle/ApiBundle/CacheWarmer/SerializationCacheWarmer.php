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

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\ApiBundle\Metadata\Loader\SerializationMetadataLoaderInterface;
use WellCommerce\Bundle\DistributionBundle\Resolver\ConfigurationFileResolverInterface;

/**
 * Class SerializationCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SerializationCacheWarmer extends CacheWarmer
{
    /**
     * @var ConfigurationFileResolverInterface
     */
    private $resolver;

    /**
     * @var array
     */
    private $mapping;

    /**
     * @var Filesystem
     */
    private $filesystem;
    
    /**
     * SerializationCacheWarmer constructor.
     *
     * @param ConfigurationFileResolverInterface $resolver
     * @param array                              $mapping
     */
    public function __construct(ConfigurationFileResolverInterface $resolver, array $mapping)
    {
        $this->resolver   = $resolver;
        $this->mapping    = $mapping;
        $this->filesystem = new Filesystem();
    }
    
    public function warmUp($cacheDir)
    {
        $configuration = $this->getConfiguration();
        
        if (count($configuration)) {
            $file = $cacheDir . '/' . SerializationMetadataLoaderInterface::CACHE_FILENAME;
            $this->writeCacheFile($file, sprintf('<?php return %s;', var_export($configuration, true)));
        }
    }
    
    private function getConfiguration() : array
    {
        $configuration = [];

        foreach ($this->mapping as $className => $options) {
            $path = $this->resolver->resolvePath($options['mapping']);
            if ($this->filesystem->exists($path)) {
                $content       = file_get_contents($path);
                $configuration = array_replace_recursive($configuration, $this->parseContent($content));
            }
        }
        
        return $configuration;
    }

    private function parseContent(string $content) : array
    {
        return Yaml::parse($content);
    }
    
    public function isOptional()
    {
        return false;
    }
}
