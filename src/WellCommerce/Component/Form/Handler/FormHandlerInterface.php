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

use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Interface FormHandlerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormHandlerInterface
{
    /**
     * Initializes the form and populates it with defaults
     *
     * @param FormInterface $form
     * @param null|object   $formModelData
     *
     * @return FormInterface
     */
    public function initForm(FormInterface $form, $formModelData);

    /**
     * Handles form request
     *
     * @param FormInterface $form
     *
     * @return FormInterface
     */
    public function handleRequest(FormInterface $form);

    /**
     * Checks whether form is valid
     *
     * @param FormInterface $form
     *
     * @return bool
     */
    public function isFormValid(FormInterface $form);

    /**
     * Checks whether form was submitted
     *
     * @param FormInterface $form
     *
     * @return bool
     */
    public function isFormSubmitted(FormInterface $form);

    /**
     * Checks whether particular form action has been used
     *
     * @param $actionName
     *
     * @return bool
     */
    public function isFormAction($actionName);

    /**
     * Returns form model data
     *
     * @return null|object
     */
    public function getFormModelData();
}
