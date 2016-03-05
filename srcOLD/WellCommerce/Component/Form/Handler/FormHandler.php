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

namespace WellCommerce\Component\Form\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Component\Form\DataMapper\FormDataMapperInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Request\FormRequestHandlerInterface;
use WellCommerce\Component\Form\Validator\FormValidatorInterface;

/**
 * Class FormHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormHandler implements FormHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var FormDataMapperInterface
     */
    protected $formDataMapper;

    /**
     * @var FormValidatorInterface
     */
    protected $formValidator;

    /**
     * @var FormRequestHandlerInterface
     */
    protected $formRequestHandler;

    /**
     * @var null|object
     */
    protected $formModelData;

    /**
     * Constructor
     *
     * @param EventDispatcherInterface    $eventDispatcher
     * @param FormDataMapperInterface     $formDataMapper
     * @param FormValidatorInterface      $formValidator
     * @param FormRequestHandlerInterface $formRequestHandler
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        FormDataMapperInterface $formDataMapper,
        FormValidatorInterface $formValidator,
        FormRequestHandlerInterface $formRequestHandler
    ) {
        $this->eventDispatcher    = $eventDispatcher;
        $this->formDataMapper     = $formDataMapper;
        $this->formValidator      = $formValidator;
        $this->formRequestHandler = $formRequestHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function initForm(FormInterface $form, $formModelData)
    {
        $this->formModelData = $formModelData;
        $this->populateForm($formModelData, $form);
        $form->setFormHandler($this);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(FormInterface $form)
    {
        if ($this->formRequestHandler->isSubmitted($form)) {
            $formSubmitValues = $this->formRequestHandler->getFormSubmitValues();
            $this->formDataMapper->mapRequestDataToForm($formSubmitValues, $form);
        }

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function isFormValid(FormInterface $form)
    {
        if ($this->formRequestHandler->isSubmitted($form)) {
            $this->formDataMapper->mapFormToData($form, $this->formModelData);

            return $this->formValidator->isValid($form);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isFormSubmitted(FormInterface $form)
    {
        return $this->formRequestHandler->isSubmitted($form);
    }

    /**
     * {@inheritdoc}
     */
    public function isFormAction($actionName)
    {
        return $this->formRequestHandler->isFormAction($actionName);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormModelData()
    {
        return $this->formModelData;
    }

    public function populateForm($formModelData, $form)
    {
        return $this->formDataMapper->mapModelDataToForm($formModelData, $form);
    }
}
