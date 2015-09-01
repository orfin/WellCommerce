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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
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
    protected $repository;

    /**
     * Constructor
     *
     * @param RepositoryInterface|null $repository
     */
    public function __construct(RepositoryInterface $repository = null)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function initResource()
    {
        return $this->repository->createNew();
    }

    /**
     * Dispatches resource event
     *
     * @param object  $resource
     * @param Request $request
     * @param string  $name
     */
    protected function dispatchEvent($resource, Request $request = null, $name)
    {
        $reflection = new \ReflectionClass($resource);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new ResourceEvent($resource, $request);
        $this->getEventDispatcher()->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, ManagerInterface::PRE_CREATE_EVENT);
        $this->saveResource($resource);
        $this->dispatchEvent($resource, $request, ManagerInterface::POST_CREATE_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, ManagerInterface::PRE_UPDATE_EVENT);
        $this->saveResource($resource);
        $this->dispatchEvent($resource, $request, ManagerInterface::POST_UPDATE_EVENT);
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

    /**
     * {@inheritdoc}
     */
    public function removeResource($resource)
    {
        $this->dispatchEvent($resource, null, ManagerInterface::PRE_REMOVE_EVENT);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->dispatchEvent($resource, null, ManagerInterface::POST_REMOVE_EVENT);
    }

    /**
     * Returns event name for particular resource
     *
     * @param string $class
     * @param string $name
     *
     * @return string
     */
    protected function getEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }
}
