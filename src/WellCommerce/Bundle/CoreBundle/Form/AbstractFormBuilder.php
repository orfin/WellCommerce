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
use WellCommerce\Component\Form\DataTransformer\DataTransformerInterface;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Filters\FilterInterface;
use WellCommerce\Component\Form\FormBuilderInterface;
use WellCommerce\Component\Form\Handler\FormHandlerInterface;
use WellCommerce\Component\Form\Resolver\FormResolverFactoryInterface;
use WellCommerce\Component\Form\Rules\RuleInterface;

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
    public function createForm(array $options, $defaultData = null) : FormInterface
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
    public function getElement(string $alias, array $options = []) : ElementInterface
    {
        return $this->initService('element', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getRule(string $alias, array $options = []) : RuleInterface
    {
        return $this->initService('rule', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter(string $alias, array $options = []) : FilterInterface
    {
        return $this->initService('filter', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependency(string $alias, array $options = []) : DependencyInterface
    {
        return $this->initService('dependency', $alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getRepositoryTransformer(string $alias, RepositoryInterface $repository) : DataTransformerInterface
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
    protected function getFormService(array $options) : FormInterface
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
    protected function initService(string $type, string $alias, array $options)
    {
        $id      = $this->resolverFactory->resolve($type, $alias);
        $service = $this->get($id);

        $service->setOptions($options);

        return $service;
    }
}
