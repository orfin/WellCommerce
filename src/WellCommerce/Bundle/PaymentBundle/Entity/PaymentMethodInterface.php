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

namespace WellCommerce\Bundle\PaymentBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

/**
 * Interface PaymentMethodInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodInterface extends
    EntityInterface,
    EnableableInterface,
    TimestampableInterface,
    TranslatableInterface,
    BlameableInterface,
    HierarchyAwareInterface
{
    /**
     * Returns payment method processor
     *
     * @return string
     */
    public function getProcessor() : string;

    /**
     * Sets payment method processor
     *
     * @param string $processor
     */
    public function setProcessor(string $processor);

    /**
     * @return Collection
     */
    public function getShippingMethods() : Collection;

    /**
     * @param Collection $shippingMethods
     */
    public function setShippingMethods(Collection $shippingMethods);

    /**
     * @return OrderStatusInterface
     */
    public function getPaymentPendingOrderStatus() : OrderStatusInterface;

    /**
     * @param OrderStatusInterface $paymentPendingOrderStatus
     */
    public function setPaymentPendingOrderStatus(OrderStatusInterface $paymentPendingOrderStatus);

    /**
     * @return OrderStatusInterface
     */
    public function getPaymentSuccessOrderStatus() : OrderStatusInterface;

    /**
     * @param OrderStatusInterface $paymentSuccessOrderStatus
     */
    public function setPaymentSuccessOrderStatus(OrderStatusInterface $paymentSuccessOrderStatus);

    /**
     * @return OrderStatusInterface
     */
    public function getPaymentFailureOrderStatus() : OrderStatusInterface;

    /**
     * @param OrderStatusInterface $paymentFailureOrderStatus
     */
    public function setPaymentFailureOrderStatus(OrderStatusInterface $paymentFailureOrderStatus);

    /**
     * @return array
     */
    public function getConfiguration() : array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);
}
