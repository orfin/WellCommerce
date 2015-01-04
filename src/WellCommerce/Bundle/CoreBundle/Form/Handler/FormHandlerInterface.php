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

use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Interface FormHandlerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormHandlerInterface
{
    /**
     * Populates the form with default values
     *
     * @param FormInterface $form
     * @param null|object   $defaultData
     */
    public function setDefaultFormData(FormInterface $form, $defaultData);

//    public function handleRequest();
//
//    public function validateForm(FormInterface $form);
//
//    public function populateFormWithData(FormInterface $form, $data = null);

}