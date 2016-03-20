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

namespace WellCommerce\Component\DataSet\Cache;

use Cache\Taggable\TaggablePoolInterface;
use Doctrine\ORM\Query;

/**
 * Interface DataSetCacheManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetCacheManager implements DataSetCacheManagerInterface
{
    /**
     * @var TaggablePoolInterface
     */
    protected $cachePool;

    /**
     * DataSetCacheManager constructor.
     *
     * @param TaggablePoolInterface $cachePool
     */
    public function __construct(TaggablePoolInterface $cachePool)
    {
        $this->cachePool = $cachePool;
    }

    public function getCachedDataSetResult(Query $query, CacheOptions $options) : array
    {
        $hash = $this->getHash($query);
        $item = $this->cachePool->getItem($hash);
        if ($item->isHit()) {
            $result = $item->get();
        } else {
            $result = $query->getArrayResult();
            $item->set($result)->setTags($options->getTags());
            $item->expiresAfter($options->getTtl());
            $this->cachePool->save($item);
        }

        return $result;
    }
    
    public function getCachedPaginatorResult(Query $query, CacheOptions $options) : array
    {
        $hash = $this->getHash($query);
        $item = $this->cachePool->getItem($hash);
        if ($item->isHit()) {
            $result = $item->get();
        } else {
            $result = $query->getArrayResult();
            $item->set($result)->setTags($options->getTags());
            $item->expiresAfter($options->getTtl());
            $this->cachePool->save($item);
        }
        
        return $result;
    }

    protected function getHash(Query $query) : string
    {
        $sql    = $query->getSQL();
        $params = $query->getParameters();

        return sha1($sql . serialize($params));
    }
}
