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

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use WellCommerce\Component\Form\Elements\ElementCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ConstraintViolationMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ConstraintViolationMapper
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Maps errors messages to all form elements
     *
     * @param ConstraintViolationListInterface $errors
     * @param FormInterface                    $form
     */
    public function mapErrorsToForm(ConstraintViolationListInterface $errors, FormInterface $form)
    {
        $messages = $this->extractMessages($errors);

        $this->mapMessagesToElementCollection($messages, $form->getChildren());
    }

    protected function extractMessages(ConstraintViolationListInterface $constraintViolationList)
    {
        $messages = [];

        foreach ($constraintViolationList as $constraintError) {
            $this->getConstraintViolation($constraintError, $messages);
        }

        return $messages;
    }

    protected function getConstraintViolation(ConstraintViolation $constraintViolation, array &$messages)
    {
        $path       = new PropertyPath($constraintViolation->getPropertyPath());
        $elements   = $path->getElements();
        $elements[] = $constraintViolation->getConstraint()->validatedBy();
        $this->propertyAccessor->setValue($messages, $this->buildPath($elements), $constraintViolation->getMessage());
    }

    /**
     * Builds property path in array-notation style from passed elements
     *
     * @param array $elements
     *
     * @return string
     */
    protected function buildPath($elements)
    {
        $wrapped = array_map(
            function ($element) {
                return "[{$element}]";
            },
            $elements
        );

        return implode('', $wrapped);
    }

    /**
     * Maps errors to elements children
     *
     * @param array             $messages
     * @param ElementCollection $children
     */
    protected function mapMessagesToElementCollection(array $messages, ElementCollection $children)
    {
        $children->forAll(function (ElementInterface $element) use ($messages) {
            $this->mapMessagesToElement($messages, $element);
        });
    }

    /**
     * Sets errors on element
     *
     * @param array            $messages
     * @param ElementInterface $element
     */
    protected function mapMessagesToElement(array $messages, ElementInterface $element)
    {
        if ($element->hasPropertyPath()) {
            $propertyPathParts = explode('.', $element->getPropertyPath(false));
            $propertyPath      = $this->buildPath($propertyPathParts);
            if ($this->propertyAccessor->isReadable($messages, $propertyPath)) {
                $errors = $this->propertyAccessor->getValue($messages, $propertyPath);
                $element->setError($errors);
            }
        }

        $children = $element->getChildren();

        if ($children->count()) {
            $this->mapMessagesToElementCollection($messages, $children);
        }
    }
}
