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
final class FormEvent extends Event
{
    const FORM_PRE_INIT_EVENT  = 'pre_form_init';
    const FORM_POST_INIT_EVENT = 'post_form_init';

    private $formBuilder;
    private $form;
    private $resource;

    /**
     * FormEvent constructor.
     *
     * @param FormBuilderInterface $formBuilder
     * @param FormInterface        $form
     * @param null                 $resource
     */
    public function __construct(FormBuilderInterface $formBuilder, FormInterface $form, $resource = null)
    {
        $this->formBuilder = $formBuilder;
        $this->form        = $form;
        $this->resource    = $resource;
    }

    public function getFormBuilder() : FormBuilderInterface
    {
        return $this->formBuilder;
    }

    public function getForm() : FormInterface
    {
        return $this->form;
    }

    /**
     * @return null|object
     */
    public function getResource()
    {
        return $this->resource;
    }
}
