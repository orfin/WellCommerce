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

namespace WellCommerce\Bundle\CoreBundle\Form\Handler;

use WellCommerce\Bundle\CoreBundle\Form\DataMapper\DataMapperInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\FormValidatorInterface;

/**
 * Class FormHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormHandler implements FormHandlerInterface
{
    /**
     * @var DataMapperInterface
     */
    protected $dataMapper;

    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * @var FormValidatorInterface
     */
    protected $formValidator;

    /**
     * Constructor
     *
     * @param DataMapperInterface     $dataMapper
     * @param RequestHandlerInterface $requestHandler
     * @param FormValidatorInterface  $formValidator
     */
    public function __construct(
        DataMapperInterface $dataMapper,
        RequestHandlerInterface $requestHandler,
        FormValidatorInterface $formValidator
    ) {
        $this->dataMapper     = $dataMapper;
        $this->requestHandler = $requestHandler;
        $this->formValidator  = $formValidator;
    }

    public function initForm(FormInterface $form, $defaultData)
    {
        $this->dataMapper->mapDataToForm($defaultData, $form);
    }

    public function isValidRequest(FormInterface $form)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultFormData(FormInterface $form, $defaultData)
    {
        $this->dataMapper->mapDataToForm($defaultData, $form);
    }

    public function handleRequest(FormInterface $form)
    {
        return $form;
    }
} 