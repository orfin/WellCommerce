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
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class FormEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class FormEvent extends Event
{
    const FORM_INIT_EVENT = 'form_init';

    private $formBuilder;
    private $form;
    private $entity;

    /**
     * FormEvent constructor.
     *
     * @param FormBuilderInterface $formBuilder
     * @param FormInterface        $form
     * @param EntityInterface|null $entity
     */
    public function __construct(FormBuilderInterface $formBuilder, FormInterface $form, EntityInterface $entity = null)
    {
        $this->formBuilder = $formBuilder;
        $this->form        = $form;
        $this->entity      = $entity;
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
    public function getEntity()
    {
        return $this->entity;
    }
}
