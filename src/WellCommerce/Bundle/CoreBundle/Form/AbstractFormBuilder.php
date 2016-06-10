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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Component\Form\DataTransformer\DataTransformerInterface;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Event\FormEvent;
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
     * @var string
     */
    protected $alias;

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
     * AbstractFormBuilder constructor.
     *
     * @param string                       $alias
     * @param FormResolverFactoryInterface $resolverFactory
     * @param FormHandlerInterface         $formHandler
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(
        string $alias,
        FormResolverFactoryInterface $resolverFactory,
        FormHandlerInterface $formHandler,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->alias           = $alias;
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
        $this->dispatchFormEvent($form, $defaultData, FormEvent::FORM_PRE_INIT_EVENT);
        $this->formHandler->initForm($form, $defaultData);
        $this->dispatchFormEvent($form, $defaultData, FormEvent::FORM_POST_INIT_EVENT);

        return $form;
    }

    /**
     * Dispatches a form event
     *
     * @param FormInterface        $form
     * @param IdentifiableEntityInterface|null $entity
     * @param string               $name
     */
    protected function dispatchFormEvent(FormInterface $form, IdentifiableEntityInterface $entity = null, string $name)
    {
        $eventName = sprintf('%s.%s', $this->alias, $name);

        $this->eventDispatcher->dispatch($eventName, new FormEvent($this, $form, $entity));
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
    
    protected function addMetadataFieldset(FormInterface $form, RepositoryInterface $repository)
    {
        $metadata = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'metadata',
            'label' => $this->trans('common.fieldset.meta')
        ]));
        
        $languageData = $metadata->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $repository)
        ]));
        
        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.title',
            'label' => $this->trans('common.label.meta.title')
        ]));
        
        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.keywords',
            'label' => $this->trans('common.label.meta.keywords'),
        ]));
        
        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'meta.description',
            'label' => $this->trans('common.label.meta.description'),
        ]));
    }
    
    protected function addShopsFieldset(FormInterface $form)
    {
        $shopsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shops_data',
            'label' => $this->trans('common.fieldset.shops')
        ]));
        
        $shopsData->addChild($this->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('common.label.shops'),
            'options'     => $this->get('shop.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shop.repository'))
        ]));
    }
}
