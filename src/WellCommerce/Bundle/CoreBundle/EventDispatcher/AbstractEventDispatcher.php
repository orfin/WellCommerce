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
use Symfony\Component\EventDispatcher\EventDispatcherInterface as BaseEventDispatcher;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\FormBundle\Event\FormEvent;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;

/**
 * Class AbstractEventDispatcher
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEventDispatcher implements EventDispatcherInterface
{
    const PRE_RESOURCE_UPDATE_EVENT  = 'pre_update';
    const POST_RESOURCE_UPDATE_EVENT = 'post_update';
    const PRE_RESOURCE_CREATE_EVENT  = 'pre_create';
    const POST_RESOURCE_CREATE_EVENT = 'post_create';
    const PRE_RESOURCE_REMOVE_EVENT  = 'pre_remove';
    const POST_RESOURCE_REMOVE_EVENT = 'post_remove';
    const FORM_INIT_EVENT            = 'form_init';
    /**
     * @var BaseEventDispatcher
     */
    protected $eventDispatcher;
    
    /**
     * Constructor
     *
     * @param BaseEventDispatcher $eventDispatcher
     */
    public function __construct(BaseEventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreCreateResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::PRE_RESOURCE_CREATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostCreateResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::POST_RESOURCE_CREATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreUpdateResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::PRE_RESOURCE_UPDATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostUpdateResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::POST_RESOURCE_UPDATE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPreRemoveResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::PRE_RESOURCE_REMOVE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnPostRemoveResource($resource)
    {
        $this->dispatchResourceEvent($resource, self::POST_RESOURCE_REMOVE_EVENT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatchOnFormInitEvent(FormBuilderInterface $builder, FormInterface $form)
    {
        $this->dispatchFormEvent($builder, $form, self::FORM_INIT_EVENT);
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
        $eventName  = $this->getResourceEventName($reflection->getShortName(), $name);
        $event      = new ResourceEvent($resource);
        $this->dispatch($eventName, $event);
    }
    
    /**
     * Dispatches resource event
     *
     * @param object $resource
     * @param string $name
     */
    protected function dispatchFormEvent(FormBuilderInterface $builder, FormInterface $form, $name)
    {
        $eventName = sprintf('%s.%s', $form->getName(), $name);
        $event     = new FormEvent($builder, $form);
        $this->dispatch($eventName, $event);
    }
    
    /**
     * @param string $eventName
     * @param Event  $event
     */
    protected function dispatch($eventName, Event $event)
    {
        $this->eventDispatcher->dispatch($eventName, $event);
    }
    
    /**
     * Returns event name for particular resource
     *
     * @param string $class
     * @param string $name
     *
     * @return string
     */
    protected function getResourceEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }
}
