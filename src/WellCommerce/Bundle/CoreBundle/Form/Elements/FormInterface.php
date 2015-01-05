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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use WellCommerce\Bundle\CoreBundle\Form\Handler\FormHandlerInterface;

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
     * Sets form handler
     *
     * @param FormHandlerInterface $formHandler
     */
    public function setFormHandler(FormHandlerInterface $formHandler);

    /**
     * Sets default form data using DataMapper
     *
     * @param $data
     */
    public function setDefaultFormData($data);
}