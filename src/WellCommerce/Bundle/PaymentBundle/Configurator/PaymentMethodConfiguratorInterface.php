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

namespace WellCommerce\Bundle\PaymentBundle\Configurator;

use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface PaymentMethodConfiguratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodConfiguratorInterface
{
    /**
     * Returns the processor's name
     *
     * @return string
     */
    public function getName() : string;
    
    /**
     * Configures the payment method
     *
     * @param PaymentMethodInterface $paymentMethod
     */
    public function configure(PaymentMethodInterface $paymentMethod);
    
    /**
     * @return array
     */
    public function getConfiguration() : array;
    
    /**
     * Adds the configuration fieldset to parent form
     *
     * @param FormBuilderInterface $builder
     * @param ElementInterface     $fieldset
     * @param DependencyInterface  $dependency
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency);
    
    /**
     * @return array
     */
    public function getSupportedConfigurationKeys() : array;
}
