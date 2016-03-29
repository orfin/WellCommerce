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
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
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
    public function getAlias() : string;

    /**
     * Returns processor name
     *
     * @return string
     */
    public function getName() : string;

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
    public function processConfiguration(Collection $collection) : array;

    /**
     * Processes a payment for order
     *
     * @param PaymentInterface $payment
     *
     * @return PaymentInterface
     */
    public function processPayment(PaymentInterface $payment) : PaymentInterface;

    /**
     * Confirms a payment for order
     *
     * @param Request $request
     *
     * @return PaymentInterface
     */
    public function confirmPayment(Request $request) : PaymentInterface;

    /**
     * Cancels a payment for order
     *
     * @param OrderInterface $order
     * @param Request        $request
     *
     * @return PaymentInterface
     */
    public function cancelPayment(OrderInterface $order, Request $request) : PaymentInterface;

    /**
     * Notifies about payment state change
     *
     * @param Request $request
     *
     * @return PaymentInterface
     */
    public function notifyPayment(Request $request) : PaymentInterface;
}
