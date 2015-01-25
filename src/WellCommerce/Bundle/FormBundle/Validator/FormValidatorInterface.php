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

namespace WellCommerce\Bundle\FormBundle\Validator;

use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Interface FormValidatorInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormValidatorInterface
{
    /**
     * Returns boolean indicating whether the form is valid
     *
     * @param FormInterface $form
     *
     * @return bool
     */
    public function isValid(FormInterface $form);

    /**
     * Sets constraints for all form fields on base of model metadata
     *
     * @param FormInterface $form
     * @param object        $modelData
     */
    public function setFormConstraintsFromModelData(FormInterface $form, $modelData);
}
