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
use WellCommerce\Bundle\CoreBundle\Form\DataCollector\DataCollectorInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Resolver\FormResolverFactoryInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\ValidatorInterface;

/**
 * Class AbstractFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormBuilder extends AbstractContainer
{
    /**
     * @var FormRendererInterface
     */
    protected $renderer;

    /**
     * @var FormResolverFactoryInterface
     */
    protected $resolverFactory;

    /**
     * @var DataCollectorInterface
     */
    protected $dataCollector;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    protected $form;

    protected $formData;

    /**
     * Constructor
     *
     * @param FormRendererInterface        $renderer
     * @param FormResolverFactoryInterface $resolverFactory
     * @param DataCollectorInterface       $dataCollector
     * @param ValidatorInterface           $validator
     * @param RequestHandlerInterface      $requestHandler
     */
    public function __construct(
        FormRendererInterface $renderer,
        FormResolverFactoryInterface $resolverFactory,
        DataCollectorInterface $dataCollector,
        ValidatorInterface $validator,
        RequestHandlerInterface $requestHandler
    ) {
        $this->renderer        = $renderer;
        $this->resolverFactory = $resolverFactory;
        $this->dataCollector   = $dataCollector;
        $this->validator       = $validator;
        $this->requestHandler  = $requestHandler;
    }

    /**
     *
     * @param array  $options
     * @param object $data
     */
    public function createForm($options, $formData)
    {
        $form = $this->initForm($options);
        $this->buildForm($form);

        die();

        $this->formData = $formData;
        $this->form     = $this->buildForm($options);
        $this->form->setDefaultData($this->formData);
        $this->form->setRenderer($this->renderer);
        $this->form->setDataCollector($this->dataCollector);
        $this->form->setValidator($this->validator);
    }

    /**
     * @param $options
     *
     * @return Form
     */
    protected function initForm($options)
    {
        $form = new Form($options);
        $form->setRenderer($this->renderer);
        $form->setDataCollector($this->dataCollector);
        $form->setValidator($this->validator);
        $form->setRequestHandler($this->requestHandler);

        return $form;
    }

    /**
     * Builds the form
     *
     * @param FormInterface $form
     *
     * @return mixed
     */
    abstract protected function buildForm(FormInterface $form);

    public function getForm()
    {
        return $this->form;
    }

    public function getFormData()
    {
        return $this->formData;
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
    public function getContainer($alias, array $options = [])
    {
        return $this->initService('container', $alias, $options);
    }

    /**
     * Returns a form element prototype
     *
     * @param       $alias
     * @param array $options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
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
        $id      = $this->resolverFactory->resolve($type, $alias);
        $service = $this->container->get($id);

        $service->setOptions($options);

        return $service;
    }

}