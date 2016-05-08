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

namespace WellCommerce\Bundle\DoctrineBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Event\EntityEvent;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Class Manager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Manager implements ManagerInterface
{
    /**
     * @var null|RepositoryInterface
     */
    private $repository;
    
    /**
     * @var null|EntityFactoryInterface
     */
    private $factory;
    
    /**
     * @var DoctrineHelperInterface
     */
    private $helper;
    
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    
    /**
     * Manager constructor.
     *
     * @param EntityFactoryInterface|null   $factory
     * @param RepositoryInterface|null $repository
     * @param DoctrineHelperInterface  $helper
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityFactoryInterface $factory = null,
        RepositoryInterface $repository = null,
        DoctrineHelperInterface $helper,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->factory         = $factory;
        $this->repository      = $repository;
        $this->helper          = $helper;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }
    
    public function getFactory() : EntityFactoryInterface
    {
        return $this->factory;
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
    
    public function getDoctrineHelper() : DoctrineHelperInterface
    {
        return $this->helper;
    }
    
    public function getEntityManager() : ObjectManager
    {
        return $this->helper->getEntityManager();
    }
    
    private function dispatchEvent(string $name, EntityInterface $entity)
    {
        $reflection = new \ReflectionClass($entity);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new EntityEvent($entity);
        $this->eventDispatcher->dispatch($eventName, $event);
    }
    
    private function getEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }
}
