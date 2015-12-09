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
    TimestampableInterface,
    ShopAwareInterface,
    PaymentMethodAwareInterface,
    ClientAwareInterface,
    CouponAwareInterface,
    ShippingMethodAwareInterface,
    ShippingCalculatorSubjectInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

    /**
     * @return float
     */
    public function getSessionId();

    /**
     * @param float $sessionId
     */
    public function setSessionId($sessionId);

    /**
     * @param OrderProductInterface $orderProduct
     */
    public function addProduct(OrderProductInterface $orderProduct);

    /**
     * @param OrderProduct $orderProduct
     */
    public function removeProduct(OrderProductInterface $orderProduct);

    /**
     * @return Collection
     */
    public function getProducts();

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products);

    /**
     * @return OrderTotal
     */
    public function getOrderTotal();

    /**
     * @param OrderTotal $orderTotal
     */
    public function setOrderTotal(OrderTotal $orderTotal);

    /**
     * @return OrderTotal
     */
    public function getProductTotal();

    /**
     * @param OrderTotal $productTotal
     */
    public function setProductTotal(OrderTotal $productTotal);

    /**
     * @return OrderTotal
     */
    public function getShippingTotal();

    /**
     * @param OrderTotal $shippingTotal
     */
    public function setShippingTotal(OrderTotal $shippingTotal);

    /**
     * @return ClientContactDetailsInterface
     */
    public function getContactDetails();

    /**
     * @param ClientContactDetailsInterface $contactDetails
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails);

    /**
     * @return ClientBillingAddressInterface
     */
    public function getBillingAddress();

    /**
     * @param ClientBillingAddressInterface $billingAddress
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress);

    /**
     * @return ClientShippingAddressInterface
     */
    public function getShippingAddress();

    /**
     * @param ClientShippingAddressInterface $shippingAddress
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress);

    /**
     * @return Collection
     */
    public function getTotals();

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
    public function getCurrentStatus();

    /**
     * @param OrderStatus $currentStatus
     */
    public function setCurrentStatus(OrderStatusInterface $currentStatus);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     */
    public function setComment($comment);

    /**
     * @return Collection
     */
    public function getPayments();

    /**
     * @param Collection $payments
     */
    public function setPayments(Collection $payments);

    /**
     * @param PaymentInterface $payment
     */
    public function addPayment(PaymentInterface $payment);
}
