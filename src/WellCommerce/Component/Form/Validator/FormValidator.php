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

namespace WellCommerce\Component\Form\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class FormValidator
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormValidator implements FormValidatorInterface
{
    /**
     * @var object
     */
    protected $data;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var ConstraintViolationMapper
     */
    protected $constraintViolationMapper;

    /**
     * FormValidator constructor.
     *
     * @param ValidatorInterface        $validator
     * @param ConstraintViolationMapper $constraintViolationMapper
     */
    public function __construct(
        ValidatorInterface $validator,
        ConstraintViolationMapper $constraintViolationMapper
    ) {
        $this->validator                 = $validator;
        $this->constraintViolationMapper = $constraintViolationMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(FormInterface $form)
    {
        $errors = $this->validator->validate($form->getModelData(), null, $form->getValidationGroups());
        if ($errors->count()) {
            $this->constraintViolationMapper->mapErrorsToForm($errors, $form);

            return false;
        }

        return true;
    }
}
