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

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;


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
     * Adds configuration fields to form fieldset
     *
     * @param FormBuilderInterface $builder
     * @param ElementInterface     $fieldset
     * @param DependencyInterface  $dependency
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency);

    /**
     * @param Collection $collection
     *
     * @return array
     */
    public function processConfiguration(Collection $collection);
}
