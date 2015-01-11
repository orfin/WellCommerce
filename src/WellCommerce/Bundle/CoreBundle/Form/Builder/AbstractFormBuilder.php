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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Handler\FormHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Resolver\FormResolverFactoryInterface;

/**
 * Class AbstractFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormBuilder extends AbstractContainer implements FormBuilderInterface
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
     * Constructor
     *
     * @param FormResolverFactoryInterface $resolverFactory
     * @param FormHandlerInterface         $formHandler
     */
    public function __construct(
        FormResolverFactoryInterface $resolverFactory,
        FormHandlerInterface $formHandler
    ) {
        $this->resolverFactory = $resolverFactory;
        $this->formHandler     = $formHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm($options, $defaultData = null)
    {
        $form = $this->getFormService($options);
        $this->buildForm($form);
        $this->formHandler->initForm($form, $defaultData);

        return $form;
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
        $service = $this->container->get($id);

        $service->setOptions($options);

        return $service;
    }
}
