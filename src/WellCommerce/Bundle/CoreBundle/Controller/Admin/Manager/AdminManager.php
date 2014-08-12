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

namespace WellCommerce\Bundle\CoreBundle\Controller\Admin\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface;

/**
 * Class AdminManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Admin\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminManager implements AdminManagerInterface
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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Constructor
     *
     * @param FlashHelperInterface     $flashHelper
     * @param RedirectHelperInterface  $redirectHelper
     * @param EventDispatcherInterface $eventDispatcher
     * @param ObjectManager            $objectManager
     */
    public function __construct(
        FlashHelperInterface $flashHelper,
        RedirectHelperInterface $redirectHelper,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager
    ) {
        $this->flashHelper     = $flashHelper;
        $this->redirectHelper  = $redirectHelper;
        $this->eventDispatcher = $eventDispatcher;
        $this->objectManager   = $objectManager;
    }

    /**
     * Persists given resource
     *
     * @param $resource
     *
     * @return mixed
     */
    private function saveResource($resource)
    {
        $this->objectManager->persist($resource);
        $this->objectManager->flush();

        return $resource;
    }

    /**
     * Manager method used to create new resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed|void
     */
    public function create($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_CREATE_EVENT);
        $this->saveResource($resource);
        $this->flashHelper->addSuccess('success');
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_CREATE_EVENT);
    }

    /**
     * Manager method used to update existing resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed|void
     */
    public function update($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_UPDATE_EVENT);
        $this->saveResource($resource);
        $this->flashHelper->addSuccess('success');
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_UPDATE_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectHelper()
    {
        return $this->redirectHelper;
    }

    /**
     * Returns event name for bundle
     *
     * @param         $name
     * @param Request $request
     *
     * @return string
     */
    private function getEventName($name, Request $request)
    {
        $bundle = $request->request->get('_bundle');
        $snake  = Helper::snake($bundle);

        return sprintf('%s.%s', $snake, $name);
    }

    /**
     * Triggers event
     *
     * @param $resource
     * @param $request
     * @param $name
     */
    private function dispatchEvent($resource, $request, $name)
    {
        $eventName = $this->getEventName($name, $request);
        $event     = new ResourceEvent($resource, $request);
        $this->eventDispatcher->dispatch($eventName, $event);
    }
}