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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;

/**
 * Interface OrderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderInterface extends
    EntityInterface,
    TimestampableInterface,
    ShopAwareInterface,
    PaymentMethodAwareInterface,
    ClientAwareInterface,
    CouponAwareInterface,
    ShippingMethodAwareInterface,
    ShippingCalculatorSubjectInterface
{
    /**
     * @return string
     */
    public function getCurrency() : string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency);

    /**
     * @return string
     */
    public function getSessionId() : string;

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId);

    /**
     * @param OrderProductInterface $orderProduct
     */
    public function addProduct(OrderProductInterface $orderProduct);

    /**
     * @param OrderProductInterface $orderProduct
     */
    public function removeProduct(OrderProductInterface $orderProduct);

    /**
     * @return Collection
     */
    public function getProducts() : Collection;

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products);

    /**
     * @return OrderTotal
     */
    public function getOrderTotal() : OrderTotal;

    /**
     * @param OrderTotal $orderTotal
     */
    public function setOrderTotal(OrderTotal $orderTotal);

    /**
     * @return OrderTotal
     */
    public function getProductTotal() : OrderTotal;

    /**
     * @param OrderTotal $productTotal
     */
    public function setProductTotal(OrderTotal $productTotal);

    /**
     * @return OrderTotal
     */
    public function getShippingTotal() : OrderTotal;

    /**
     * @param OrderTotal $shippingTotal
     */
    public function setShippingTotal(OrderTotal $shippingTotal);

    /**
     * @return ClientContactDetailsInterface
     */
    public function getContactDetails() : ClientContactDetailsInterface;

    /**
     * @param ClientContactDetailsInterface $contactDetails
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails);

    /**
     * @return ClientBillingAddressInterface
     */
    public function getBillingAddress() : ClientBillingAddressInterface;

    /**
     * @param ClientBillingAddressInterface $billingAddress
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress);

    /**
     * @return ClientShippingAddressInterface
     */
    public function getShippingAddress() : ClientShippingAddressInterface;

    /**
     * @param ClientShippingAddressInterface $shippingAddress
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress);

    /**
     * @return Collection
     */
    public function getTotals() : Collection;

    /**
     * @param Collection $totals
     */
    public function setTotals(Collection $totals);

    /**
     * @param OrderTotalDetailInterface $total
     */
    public function addTotal(OrderTotalDetailInterface $total);

    /**
     * @return OrderStatusInterface
     */
    public function getCurrentStatus() : OrderStatusInterface;

    /**
     * @param OrderStatusInterface $currentStatus
     */
    public function setCurrentStatus(OrderStatusInterface $currentStatus);

    /**
     * @return Collection
     */
    public function getOrderStatusHistory() : Collection;

    /**
     * @param Collection $orderStatusHistory
     */
    public function setOrderStatusHistory(Collection $orderStatusHistory);

    /**
     * {@inheritdoc}
     */
    public function addOrderStatusHistory(OrderStatusHistoryInterface $orderStatusHistory);

    /**
     * @return string
     */
    public function getComment() : string;

    /**
     * @param string $comment
     */
    public function setComment(string $comment);

    /**
     * @return Collection
     */
    public function getPayments() : Collection;

    /**
     * @param Collection $payments
     */
    public function setPayments(Collection $payments);

    /**
     * @param PaymentInterface $payment
     */
    public function addPayment(PaymentInterface $payment);
}
