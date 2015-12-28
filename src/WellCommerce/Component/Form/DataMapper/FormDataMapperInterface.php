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

namespace WellCommerce\Component\Form\DataMapper;

use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Interface FormDataMapperInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormDataMapperInterface
{
    /**
     * Maps model data to all form children
     *
     * @param object        $modelData
     * @param FormInterface $form
     */
    public function mapModelDataToForm($modelData, FormInterface $form);

    /**
     * Maps submitted values to form elements
     *
     * @param array         $data
     * @param FormInterface $form
     */
    public function mapRequestDataToForm($data, FormInterface $form);

    /**
     * Maps form values to model data
     *
     * @param FormInterface $form
     * @param object        $modelData
     */
    public function mapFormToData(FormInterface $form, $modelData);
}
