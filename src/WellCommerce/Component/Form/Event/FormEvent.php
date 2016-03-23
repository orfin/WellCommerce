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
namespace WellCommerce\Component\Form\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class FormEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormEvent extends Event
{
    const FORM_INIT_EVENT = 'form_init';

    /**
     * Form builder instance
     *
     * @var FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var null|object
     */
    protected $defaultData;

    /**
     * FormEvent constructor.
     *
     * @param FormBuilderInterface $formBuilder
     * @param FormInterface        $form
     * @param null|object          $defaultData
     */
    public function __construct(FormBuilderInterface $formBuilder, FormInterface $form, $defaultData = null)
    {
        $this->formBuilder = $formBuilder;
        $this->form        = $form;
        $this->defaultData = $defaultData;
    }

    /**
     * Returns form builder instance
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * Returns a form instance
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return null|object
     */
    public function getDefaultData()
    {
        return $this->defaultData;
    }
}
