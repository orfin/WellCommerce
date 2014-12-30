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
use WellCommerce\Bundle\CoreBundle\Form\DataMapper\DataMapperInterface;
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
     * @var DataMapperInterface
     */
    protected $dataMapper;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * Constructor
     *
     * @param FormResolverFactoryInterface $resolverFactory
     * @param DataMapperInterface          $dataMapper
     * @param ValidatorInterface           $validator
     * @param RequestHandlerInterface      $requestHandler
     */
    public function __construct(
        FormResolverFactoryInterface $resolverFactory,
        DataMapperInterface $dataMapper,
        ValidatorInterface $validator,
        RequestHandlerInterface $requestHandler
    ) {
        $this->resolverFactory = $resolverFactory;
        $this->dataMapper      = $dataMapper;
        $this->validator       = $validator;
        $this->requestHandler  = $requestHandler;
    }

    /**
     * Creates the form
     *
     * @param $options
     * @param $formData
     *
     * @return FormInterface
     */
    public function createForm($options, $formData = null)
    {
        $form = $this->initForm($options);
        $this->buildForm($form);
        $this->dataMapper->mapDataToForm($formData, $form);

        return $form;
    }

    /**
     * @param $options
     *
     * @return FormInterface
     */
    protected function initForm($options)
    {
        $form = $this->getElement('form', $options);
        $form->setDataMapper($this->dataMapper);
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

    /**
     * @return mixed
     */
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