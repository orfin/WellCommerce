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

namespace WellCommerce\Bundle\CoreBundle\Form;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;
use WellCommerce\Component\Form\Handler\FormHandlerInterface;
use WellCommerce\Component\Form\Resolver\FormResolverFactoryInterface;

/**
 * Class AbstractFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormBuilder extends AbstractContainerAware implements FormBuilderInterface
{
    /**
     * @var FormResolverFactoryInterface
     */
    protected $resolverFactory;

    /**
     * @var FormHandlerInterface
     */
    protected $formHandler;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param FormResolverFactoryInterface $resolverFactory
     * @param FormHandlerInterface         $formHandler
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(
        FormResolverFactoryInterface $resolverFactory,
        FormHandlerInterface $formHandler,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->resolverFactory = $resolverFactory;
        $this->formHandler     = $formHandler;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm($options, $defaultData = null)
    {
        $form = $this->getFormService($options);
        $this->buildForm($form);
        $this->eventDispatcher->dispatchOnFormInitEvent($this, $form, $defaultData);
        $this->formHandler->initForm($form, $defaultData);

        return $form;
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

    /**
     * {@inheritdoc}
     */
    public function getRepositoryTransformer($alias, RepositoryInterface $repository)
    {
        /** @var $transformer \WellCommerce\Component\Form\DataTransformer\DataTransformerInterface */
        $transformer = $this->get('form.data_transformer.factory')->createRepositoryTransformer($alias);
        $transformer->setRepository($repository);

        return $transformer;
    }

    /**
     * Initializes form service
     *
     * @param array $options
     *
     * @return FormInterface
     */
    protected function getFormService($options)
    {
        return $this->getElement('form', $options);
    }

    /**
     * Builds the form
     *
     * @param FormInterface $form
     */
    abstract protected function buildForm(FormInterface $form);

    /**
     * Initializes a service by its type
     *
     * @param string $type
     * @param string $alias
     * @param array  $options
     *
     * @return object
     */
    protected function initService($type, $alias, $options)
    {
        $id      = $this->resolverFactory->resolve($type, $alias);
        $service = $this->get($id);

        $service->setOptions($options);

        return $service;
    }
}
