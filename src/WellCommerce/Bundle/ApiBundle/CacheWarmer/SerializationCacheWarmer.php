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

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\ApiBundle\Metadata\Loader\SerializationMetadataLoaderInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class SerializationCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationCacheWarmer extends CacheWarmer
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;
    
    /**
     * @var Filesystem
     */
    protected $filesystem;
    
    /**
     * SerializationCacheWarmer constructor.
     *
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper)
    {
        $this->doctrineHelper = $doctrineHelper;
        $this->filesystem     = new Filesystem();
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
        $configuration      = [];
        $metadataCollection = $this->doctrineHelper->getMetadataFactory()->getAllMetadata();
        
        foreach ($metadataCollection as $entityMetadata) {
            $this->appendConfigurationFromMetadata($entityMetadata, $configuration);
        }
        
        return $configuration;
    }
    
    protected function appendConfigurationFromMetadata(ClassMetadata $metadata, &$configuration)
    {
        $serializationFilePath = $this->resolvePath($metadata->getReflectionClass());
        if ($this->filesystem->exists($serializationFilePath)) {
            $content       = file_get_contents($serializationFilePath);
            $configuration = array_replace_recursive($configuration, $this->parseContent($content));
        }
    }
    
    protected function resolvePath(\ReflectionClass $reflectionClass)
    {
        return dirname($reflectionClass->getFileName()) . '/../Resources/config/serialization/' . $reflectionClass->getShortName() . '.yml';
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
