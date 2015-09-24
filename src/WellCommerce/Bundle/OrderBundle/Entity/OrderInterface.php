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
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopAwareInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareInterface;

/**
 * Interface OrderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderInterface extends TimestampableInterface, ShopAwareInterface, ShippingMethodAwareInterface, PaymentMethodAwareInterface, ClientAwareInterface
{
    /**
     * @return int
     */
    public function getId();

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
     * @return AddressInterface
     */
    public function getBillingAddress();

    /**
     * @param AddressInterface $billingAddress
     */
    public function setBillingAddress(AddressInterface $billingAddress);

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress(AddressInterface $shippingAddress);

    /**
     * @return Collection
     */
    public function getModifiers();

    /**
     * @param Collection $modifiers
     */
    public function setModifiers(Collection $modifiers);

    /**
     * @param OrderModifierInterface $orderModifier
     */
    public function addModifier(OrderModifierInterface $orderModifier);

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
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

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
