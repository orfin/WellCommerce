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
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;

/**
 * Class AbstractAdminManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractAdminManager extends AbstractManager implements AdminManagerInterface
{
    /**
     * @var DataGridInterface
     */
    private $datagrid;

    /**
     * @var FormInterface
     */
    private $formBuilder;

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
     * Sets form builder
     *
     * @param FormBuilderInterface $formBuilder
     */
    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Returns form builder
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
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
        $this->getFlashHelper()->addSuccess('success');
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
        $this->getEventDispatcher()->dispatch($eventName, $event);
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
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->persist($resource);
        $em->flush();

        return $resource;
    }

    public function removeResource($resource)
    {
        $this->dispatchEvent($resource, null, AdminManagerInterface::PRE_REMOVE_EVENT);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->dispatchEvent($resource, null, AdminManagerInterface::POST_REMOVE_EVENT);
    }

    /**
     * Updates resource
     *
     * @param object  $resource
     * @param Request $request
     *
     * @return void
     */
    public function updateResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_UPDATE_EVENT);
        $this->saveResource($resource);
        $this->getFlashHelper()->addSuccess('success');
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_UPDATE_EVENT);
    }
}