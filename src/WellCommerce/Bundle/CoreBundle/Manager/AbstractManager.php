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
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Exception\MissingEventDispatcherException;
use WellCommerce\Bundle\CoreBundle\Exception\MissingFactoryException;
use WellCommerce\Bundle\CoreBundle\Exception\MissingRepositoryException;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager extends AbstractContainerAware implements ManagerInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Constructor
     *
     * @param RepositoryInterface|null      $repository
     * @param FactoryInterface|null         $factory
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function __construct(RepositoryInterface $repository = null, FactoryInterface $factory = null, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->repository      = $repository;
        $this->factory         = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        if (null === $this->repository) {
            throw new MissingRepositoryException(get_class($this));
        }

        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactory()
    {
        if (null === $this->factory) {
            throw new MissingFactoryException(get_class($this));
        }

        return $this->factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher()
    {
        if (null === $this->eventDispatcher) {
            throw new MissingEventDispatcherException(get_class($this));
        }

        return $this->eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function initResource()
    {
        return $this->getFactory()->create();
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreCreateResource($resource);
        $this->saveResource($resource);
        $this->getEventDispatcher()->dispatchOnPostCreateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreUpdateResource($resource);
        $this->saveResource($resource);
        $this->getEventDispatcher()->dispatchOnPostUpdateResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function removeResource($resource)
    {
        $this->getEventDispatcher()->dispatchOnPreRemoveResource($resource);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->getEventDispatcher()->dispatchOnPostRemoveResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    protected function saveResource($resource)
    {
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->persist($resource);
        $em->flush();

        return $resource;
    }
}
