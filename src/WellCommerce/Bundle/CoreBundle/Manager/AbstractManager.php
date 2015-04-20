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
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManager implements ManagerInterface
{
    /**
     * @var FlashHelperInterface
     */
    private $flashHelper;

    /**
     * @var RedirectHelperInterface
     */
    private $redirectHelper;

    /**
     * @var ImageHelperInterface
     */
    private $imageHelper;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var DoctrineHelperInterface
     */
    private $doctrineHelper;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param FlashHelperInterface     $flashHelper
     * @param RedirectHelperInterface  $redirectHelper
     * @param ImageHelperInterface     $imageHelper
     * @param EventDispatcherInterface $eventDispatcher
     * @param DoctrineHelperInterface  $doctrineHelper
     * @param TranslatorInterface      $translator
     */
    public function __construct(
        FlashHelperInterface $flashHelper,
        RedirectHelperInterface $redirectHelper,
        ImageHelperInterface $imageHelper,
        EventDispatcherInterface $eventDispatcher,
        DoctrineHelperInterface $doctrineHelper,
        TranslatorInterface $translator
    ) {
        $this->flashHelper     = $flashHelper;
        $this->redirectHelper  = $redirectHelper;
        $this->imageHelper     = $imageHelper;
        $this->eventDispatcher = $eventDispatcher;
        $this->doctrineHelper  = $doctrineHelper;
        $this->translator      = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectHelper()
    {
        return $this->redirectHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlashHelper()
    {
        return $this->flashHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getDoctrineHelper()
    {
        return $this->doctrineHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(RepositoryInterface $repository)
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
