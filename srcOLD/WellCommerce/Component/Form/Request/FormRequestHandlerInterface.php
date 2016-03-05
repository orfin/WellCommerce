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

namespace WellCommerce\Component\Form\Request;

use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Interface FormRequestHandlerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormRequestHandlerInterface
{
    /**
     * Returns submit values from request
     *
     * @return array
     */
    public function getFormSubmitValues();

    /**
     * Checks whether form was submitted
     *
     * @param FormInterface $form
     *
     * @return bool
     */
    public function isSubmitted(FormInterface $form);

    /**
     * Checks whether particular form action has been used
     *
     * @param $actionName
     *
     * @return bool
     */
    public function isFormAction($actionName);
}
