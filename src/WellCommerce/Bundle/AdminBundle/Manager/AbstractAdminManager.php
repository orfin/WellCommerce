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

namespace WellCommerce\Bundle\AdminBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
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
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * {@inheritdoc}
     */
    public function setDataGrid(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGrid()
    {
        return $this->datagrid->getInstance();
    }

    /**
     * {@inheritdoc}
     */
    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm($resource, array $config = [])
    {
        $defaultConfig = [
            'name' => $this->getRepository()->getAlias(),
        ];

        $config = array_merge($defaultConfig, $config);

        return $this->formBuilder->createForm($config, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function initResource()
    {
        return $this->getRepository()->createNew();
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_CREATE_EVENT);
        $this->saveResource($resource);
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_CREATE_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($resource, Request $request)
    {
        $this->dispatchEvent($resource, $request, AdminManagerInterface::PRE_UPDATE_EVENT);
        $this->saveResource($resource);
        $this->dispatchEvent($resource, $request, AdminManagerInterface::POST_UPDATE_EVENT);
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
        $this->dispatchEvent($resource, null, AdminManagerInterface::PRE_REMOVE_EVENT);
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($resource);
        $em->flush();
        $this->dispatchEvent($resource, null, AdminManagerInterface::POST_REMOVE_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function findResource(Request $request)
    {
        $this->getDoctrineHelper()->disableFilter('locale');

        if (!$request->attributes->has('id')) {
            throw new \LogicException('Request does not have "id" attribute set.');
        }

        $id       = $request->attributes->get('id');
        $resource = $this->getRepository()->find($id);

        return $resource;
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
