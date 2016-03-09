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

namespace WellCommerce\Bundle\CoreBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as BaseEventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\DataSet\Event\DataSetEvent;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Event\FormEvent;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class EventDispatcher
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var BaseEventDispatcherInterface
     */
    protected $baseEventDispatcher;
    
    /**
     * Constructor
     *
     * @param BaseEventDispatcherInterface $baseEventDispatcher
     */
    public function __construct(BaseEventDispatcherInterface $baseEventDispatcher)
    {
        $this->baseEventDispatcher = $baseEventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostInitResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::POST_RESOURCE_INIT_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreCreateResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::PRE_RESOURCE_CREATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostCreateResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::POST_RESOURCE_CREATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreUpdateResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::PRE_RESOURCE_UPDATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostUpdateResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::POST_RESOURCE_UPDATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreRemoveResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::PRE_RESOURCE_REMOVE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostRemoveResource($resource)
    {
        $this->dispatchResourceEvent($resource, EventDispatcherInterface::POST_RESOURCE_REMOVE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnFormInitEvent(FormBuilderInterface $builder, FormInterface $form, $defaultData)
    {
        $this->dispatchFormEvent($builder, $form, $defaultData, EventDispatcherInterface::FORM_INIT_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchOnDataSetInitEvent(DataSetInterface $dataset)
    {
        $this->dispatchDataSetEvent($dataset, EventDispatcherInterface::DATASET_INIT_EVENT);
    }
    
    /**
     * Dispatches resource event
     *
     * @param object $resource
     * @param string $name
     */
    protected function dispatchResourceEvent($resource, $name)
    {
        $reflection = new \ReflectionClass($resource);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new ResourceEvent($resource);
        $this->dispatch($eventName, $event);
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
    
    /**
     * @param string $eventName
     * @param Event  $event
     */
    protected function dispatch($eventName, Event $event)
    {
        $this->baseEventDispatcher->dispatch($eventName, $event);
    }
    
    /**
     * Dispatches form init event
     *
     * @param FormBuilderInterface $builder
     * @param FormInterface        $form
     * @param object               $defaultData
     * @param string               $name
     */
    protected function dispatchFormEvent(FormBuilderInterface $builder, FormInterface $form, $defaultData, $name)
    {
        $eventName = sprintf('%s.%s', $form->getName(), $name);
        $event     = new FormEvent($builder, $form, $defaultData);
        $this->dispatch($eventName, $event);
    }

    /**
     * Dispatches dataset event
     *
     * @param object $dataset
     * @param string $name
     */
    protected function dispatchDataSetEvent(DataSetInterface $dataset, $name)
    {
        $reflection  = new \ReflectionClass($dataset);
        $dataSetName = str_replace('DataSet', '', $reflection->getShortName());
        $eventName   = $this->getEventName($dataSetName, $name);
        $event       = new DataSetEvent($dataset);
        $this->dispatch($eventName, $event);
    }
}
