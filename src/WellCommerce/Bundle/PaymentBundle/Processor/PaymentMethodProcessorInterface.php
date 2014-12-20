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

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;

/**
 * Interface PaymentMethodProcessorInterface
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodProcessorInterface
{
    /**
     * Returns processor alias
     *
     * @return mixed
     */
    public function getAlias();

    /**
     * Returns processor name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Adds payment method configuration fieldset
     *
     * @param FormBuilderInterface $builder
     * @param Form                 $form
     * @param                      $resource
     *
     * @return Fieldset
     */
    public function addConfigurationFieldset(FormBuilderInterface $builder, Form $form, $resource);

    /**
     * Adds configuration fields
     *
     * @param FormBuilderInterface $builderInterface
     * @param Fieldset             $fieldset
     *
     * @return mixed
     */
    public function addFields(FormBuilderInterface $builderInterface, Fieldset $fieldset);
}