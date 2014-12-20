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

namespace WellCommerce\Bundle\CoreBundle\Manager\Admin;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class AbstractAdminManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractAdminManager extends AbstractManager implements AdminManagerInterface
{
    /**
     * @var DataGridInterface
     */
    protected $datagrid;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @param DataGridInterface $datagrid
     */
    public function setDataGrid(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
    }

    public function getDataGrid()
    {
        return $this->datagrid;
    }

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Manager method used to create new resource
     *
     * @param object  $resource
     * @param Request $request
     *
     * @return mixed|void
     */
    public function createResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_CREATE_EVENT);
        $this->saveResource($resource);
        $this->flashHelper->addSuccess('success');
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_CREATE_EVENT);
    }

    /**
     * Triggers event
     *
     * @param $resource
     * @param $request
     * @param $name
     */
    protected function dispatchEvent($resource, $request, $name)
    {
        $reflection = new \ReflectionClass($resource);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new ResourceEvent($resource, $request);
        $this->eventDispatcher->dispatch($eventName, $event);
    }

    /**
     * Returns event name for resource
     *
     * @param $class
     * @param $name
     *
     * @return string
     */
    protected function getEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }

    /**
     * Persists given resource
     *
     * @param object $resource
     *
     * @return mixed
     */
    protected function saveResource($resource)
    {
        $this->objectManager->persist($resource);
        $this->objectManager->flush();

        return $resource;
    }

    public function removeResource($resource)
    {
        $this->dispatchEvent($resource, null, AdminManagerInterface::PRE_REMOVE_EVENT);
        $this->objectManager->remove($resource);
        $this->objectManager->flush();
        $this->dispatchEvent($resource, null, AdminManagerInterface::POST_REMOVE_EVENT);
    }

    /**
     * Manager method used to update existing resource
     *
     * @param object  $resource
     * @param Request $request
     *
     * @return mixed|void
     */
    public function updateResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_UPDATE_EVENT);
        $this->saveResource($resource);
        $this->flashHelper->addSuccess('success');
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_UPDATE_EVENT);
    }
}