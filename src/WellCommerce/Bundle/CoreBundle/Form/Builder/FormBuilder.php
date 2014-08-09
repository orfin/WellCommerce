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

use Doctrine\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;
use WellCommerce\Bundle\CoreBundle\AbstractComponent;
use WellCommerce\Bundle\CoreBundle\Form\Conditions\ConditionInterface;
use WellCommerce\Bundle\CoreBundle\Form\Dependency;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Option;
use WellCommerce\Bundle\CoreBundle\Model\ModelInterface;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;
use WellCommerce\Bundle\CoreBundle\Form\Elements;
use WellCommerce\Bundle\CoreBundle\Form\Filters;
use WellCommerce\Bundle\CoreBundle\Form\Rules;
use WellCommerce\Bundle\CoreBundle\Form\Conditions;

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
}