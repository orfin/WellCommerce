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

namespace WellCommerce\Bundle\ApiBundle\Metadata\Loader;

use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\ApiBundle\Metadata\Collection\SerializationMetadataCollection;
use WellCommerce\Bundle\ApiBundle\Metadata\Factory\SerializationClassMetadataFactory;

/**
 * Class SerializationMetadataLoader
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationMetadataLoader implements SerializationMetadataLoaderInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * SerializationMetadataLoader constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function loadMetadata()
    {
        $factory    = new SerializationClassMetadataFactory();
        $cache      = $this->getMetadataCache();
        $collection = new SerializationMetadataCollection();

        foreach ($cache as $className => $parameters) {
            $metadata = $factory->create($className, $parameters);
            $collection->add($metadata);
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    protected function getMetadataCache()
    {
        if (empty($this->cache)) {
            if (is_file($cache = $this->kernel->getCacheDir() . '/' . self::CACHE_FILENAME)) {
                $this->cache = require $cache;
            }
        }

        return $this->cache;
    }
}
