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
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;

/**
 * Class FormBuilder
 *
 * @package WellCommerce\Bundle\CoreBundle\Form
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
     * {@inheritdoc}
     */
    public function create(FormInterface $form, $data = null, array $options)
    {
        $this->options  = $options;
        $this->data     = $data;
        $this->form     = $form->buildForm($this, $this->options)->setDefaultData($this->data);
        $this->formData = $form->getDefaultData($this->data);
        $this->dispatchEvent($this->getInitEventName($options['name']));
        $this->form->populate($this->formData);

        return $this;
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
        $this->getDispatcher()->dispatch($eventName, $event);
    }

    private function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * Returns init event name
     *
     * @param $formName
     *
     * @return string
     */
    private function getInitEventName($formName)
    {
        return sprintf('%s.%s', $formName, FormBuilderInterface::FORM_INIT_EVENT);
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
    public function setData(array $data)
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
    public function getElement($type, array $options = [])
    {
        return $this->container->get('form.resolver.element')->get($type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getRule($type, array $options = [])
    {
        return $this->container->get('form.resolver.rule')->get($type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter($type, array $options = [])
    {
        return $this->container->get('form.resolver.filter')->get($type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependency($type, $options)
    {
        return $this->container->get('form.resolver.dependency')->get($type, $options);

    }
}