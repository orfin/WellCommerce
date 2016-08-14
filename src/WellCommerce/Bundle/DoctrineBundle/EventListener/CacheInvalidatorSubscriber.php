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

namespace WellCommerce\Bundle\DoctrineBundle\EventListener;

use Cache\Taggable\TaggablePoolInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use WellCommerce\Component\DataSet\Paginator\DataSetPaginatorInterface;

/**
 * Class CacheInvalidatorSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CacheInvalidatorSubscriber implements EventSubscriber
{
    /**
     * @var TaggablePoolInterface
     */
    protected $cachePool;
    
    /**
     * CacheInvalidatorSubscriber constructor.
     *
     * @param TaggablePoolInterface $cachePool
     */
    public function __construct(TaggablePoolInterface $cachePool)
    {
        $this->cachePool = $cachePool;
    }
    
    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        $scheduledEntityChanges = [
            'insert' => $uow->getScheduledEntityInsertions(),
            'update' => $uow->getScheduledEntityUpdates(),
            'delete' => $uow->getScheduledEntityDeletions()
        ];
        
        $cacheIds = [];
        
        foreach ($scheduledEntityChanges as $change => $entities) {
            foreach ($entities as $entity) {
                $cacheIds[get_class($entity)] = get_class($entity);
            }
        }
        
        if (count($cacheIds)) {
            $this->cachePool->clearTags($cacheIds);
            $em->getConfiguration()->getResultCacheImpl()->delete(DataSetPaginatorInterface::RESULT_CACHE_ID);
        }
    }
    
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];
    }
}
