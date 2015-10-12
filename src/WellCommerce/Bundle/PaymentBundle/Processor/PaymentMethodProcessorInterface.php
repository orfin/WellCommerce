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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\FormBundle\FormBuilderInterface;


/**
 * Interface PaymentMethodProcessorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodProcessorInterface
{
    /**
     * Returns processor alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns processor name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the configuration fieldset for payment method
     *
     * @param FormBuilderInterface $builder
     * @param FormInterface        $form
     * @param ElementInterface     $processorTypeSelect
     */
    public function addConfigurationFieldset(FormBuilderInterface $builder, FormInterface $form, ElementInterface $processorTypeSelect);
}
