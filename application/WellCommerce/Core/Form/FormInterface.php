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

namespace WellCommerce\Core\Form;

use WellCommerce\Core\Form\Builder\FormBuilderInterface;

/**
 * Interface FormInterface
 *
 * @package WellCommerce\Core\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormInterface
{
    /**
     * Builds the form
     *
     * @param FormBuilderInterface $builder FormBuilder instance
     * @param array                $options Form options
     *
     * @return object
     */
    public function buildForm(FormBuilderInterface $builder, array $options);
}