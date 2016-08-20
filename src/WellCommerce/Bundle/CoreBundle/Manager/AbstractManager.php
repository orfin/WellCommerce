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

namespace WellCommerce\Bundle\CoreBundle\Manager;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Event\EntityEvent;
use WellCommerce\Bundle\CoreBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class Manager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager extends AbstractContainerAware implements ManagerInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    
    /**
     * @var EntityFactoryInterface
     */
    protected $factory;
    
    /**
     * AbstractManager constructor.
     *
     * @param EntityFactoryInterface $factory
     * @param RepositoryInterface    $repository
     */
    public function __construct(EntityFactoryInterface $factory, RepositoryInterface $repository)
    {
        $this->factory    = $factory;
        $this->repository = $repository;
    }
    
    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }
    
    public function initResource() : EntityInterface
    {
        $entity = $this->factory->create();
        $this->dispatchEvent(self::POST_ENTITY_INIT_EVENT, $entity);
        
        return $entity;
    }
    
    public function createResource(EntityInterface $entity, bool $flush = true)
    {
        $this->dispatchEvent(self::PRE_ENTITY_CREATE_EVENT, $entity);
        $this->getEntityManager()->persist($entity);
        $this->dispatchEvent(self::POST_ENTITY_CREATE_EVENT, $entity);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function updateResource(EntityInterface $entity, bool $flush = true)
    {
        $this->dispatchEvent(self::PRE_ENTITY_UPDATE_EVENT, $entity);
        $this->getEntityManager()->persist($entity);
        $this->dispatchEvent(self::POST_ENTITY_UPDATE_EVENT, $entity);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function removeResource(EntityInterface $entity, bool $flush = true)
    {
        $this->dispatchEvent(self::PRE_ENTITY_REMOVE_EVENT, $entity);
        $this->getEntityManager()->remove($entity);
        $this->dispatchEvent(self::POST_ENTITY_REMOVE_EVENT, $entity);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    private function dispatchEvent(string $name, EntityInterface $entity)
    {
        $reflection = new \ReflectionClass($entity);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new EntityEvent($entity);
        $this->getEventDispatcher()->dispatch($eventName, $event);
    }
    
    private function getEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }
}
