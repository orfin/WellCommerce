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

namespace WellCommerce\Component\Form\Elements;

use WellCommerce\Component\Form\Handler\FormHandlerInterface;

/**
 * Interface FormInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormInterface extends ElementInterface
{
    const TABS_VERTICAL   = 0;
    const TABS_HORIZONTAL = 1;
    const FORM_METHOD     = 'POST';

    /**
     * @param FormHandlerInterface $formHandler
     */
    public function setFormHandler(FormHandlerInterface $formHandler);

    /**
     * Sets model data
     *
     * @param object $modelData
     */
    public function setModelData($modelData);

    /**
     * Returns model object bound to form
     *
     * @return object
     */
    public function getModelData();

    /**
     * Handles form submission
     *
     * @return FormInterface
     */
    public function handleRequest();

    /**
     * Checks whether form data is valid
     *
     * @return bool
     */
    public function isValid();

    /**
     * Checks whether form was submitted
     *
     * @return bool
     */
    public function isSubmitted();

    /**
     * Checks whether particular form action has been used
     *
     * @param $actionName
     *
     * @return bool
     */
    public function isAction($actionName);

    /**
     * Returns an array of all validation groups or null if not given
     *
     * @return null|array
     */
    public function getValidationGroups();
}
