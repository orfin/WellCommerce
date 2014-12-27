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

namespace WellCommerce\Bundle\CoreBundle\Form\Builder;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Form\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Resolver\FormResolverFactoryInterface;

/**
 * Class FormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormBuilder extends ContainerAware implements FormBuilderInterface
{
    /**
     * @var FormInterface Form instance
     */
    private $form;

    /**
     * @var object Data passed to form instance
     */
    private $data;

    /**
     * @var array Form options
     */
    private $options;

    /**
     * @var FormResolverFactoryInterface
     */
    private $formResolverFactory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Constructor
     *
     * @param FormResolverFactoryInterface $formResolverFactory
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(
        FormResolverFactoryInterface $formResolverFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->formResolverFactory = $formResolverFactory;
        $this->eventDispatcher     = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function create(FormInterface $form, $data, array $options)
    {
        $this->options = $options;
        $this->data    = $data;
        $this->form    = $form->buildForm($this, $this->options);
        $this->dispatchEvent($this->getInitEventName($form));
        $this->form->setValidationMetadata($this->getValidationMetadata($data));
        $this->form->setDefaultData($this->data);

        return $this;
    }

    private function getValidationMetadata($data)
    {
        $className   = get_class($data);
        $constraints = [];

//        if ($this->getEntityManager()->getMetadataFactory()->hasMetadataFor($className)) {
//            $metadata        = $this->getEntityManager()->getClassMetadata($className);
//            $metadataFactory = $this->getValidator()->getMetadataFactory();
//
//            foreach ($metadata->getAssociationMappings() as $association) {
//                $targetEntity = $association['targetEntity'];
//                if ($metadataFactory->hasMetadataFor($targetEntity)) {
//                    $targetEntityMetadata = $metadataFactory->getMetadataFor($targetEntity);
//                    if (!empty($targetEntityMetadata->members)) {
//                        $constraints[$association['fieldName']] = $targetEntityMetadata;
//                    }
//                }
//            }
//        }

        return $constraints;
    }

    /**
     * Triggers the event for form action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    private function dispatchEvent($eventName)
    {
        $event = new FormEvent($this);
        $this->eventDispatcher->dispatch($eventName, $event);
    }

    /**
     * Returns init event name
     *
     * @param $formName
     *
     * @return string
     */
    /**
     * Returns form init event name
     * If form has defined constant, it will be used instead of auto-generating event name
     *
     * @param $form
     *
     * @return mixed|string
     */
    private function getInitEventName($form)
    {
        $refClass = new \ReflectionClass($form);
        if ($refClass->hasConstant('FORM_INIT_EVENT')) {
            return $refClass->getConstant('FORM_INIT_EVENT');
        }

        return sprintf('%s.%s', $this->options['name'], FormBuilderInterface::FORM_INIT_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function init($options)
    {
        return $this->container->get('form.element.form')->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getElement($alias, array $options = [])
    {
        return $this->initService('element', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getRule($alias, array $options = [])
    {
        return $this->initService('rule', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter($alias, array $options = [])
    {
        return $this->initService('filter', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependency($alias, array $options = [])
    {
        return $this->initService('dependency', $alias, $options);
    }

    protected function initService($type, $alias, $options)
    {
        $id      = $this->formResolverFactory->resolve($type, $alias);
        $service = $this->container->get($id);

        $service->setOptions($options);

        return $service;
    }
}