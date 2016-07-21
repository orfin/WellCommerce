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
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
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
    ClientContactDetailsAwareInterface,
    ClientBillingAddressAwareInterface,
    ClientShippingAddressAwareInterface,
    CouponAwareInterface,
    ShippingMethodAwareInterface
{
    public function isConfirmed() : bool;
    
    public function setConfirmed(bool $confirmed);
    
    public function getNumber();
    
    public function setNumber(string $number);
    
    public function getCurrency() : string;
    
    public function setCurrency(string $currency);
    
    public function getCurrencyRate() : float;
    
    public function setCurrencyRate(float $currencyRate);
    
    public function getSessionId() : string;
    
    public function setSessionId(string $sessionId);
    
    public function addProduct(OrderProductInterface $orderProduct);
    
    public function removeProduct(OrderProductInterface $orderProduct);
    
    public function getProducts() : Collection;
    
    public function setProducts(Collection $products);
    
    public function getProductTotal() : OrderProductTotalInterface;
    
    public function setProductTotal(OrderProductTotalInterface $productTotal);
    
    public function addModifier(OrderModifierInterface $modifier);
    
    public function hasModifier(string $name) : bool;
    
    public function removeModifier(string $name);
    
    public function getModifier(string $name) : OrderModifierInterface;
    
    public function getModifiers() : Collection;
    
    public function setModifiers(Collection $modifiers);
    
    public function getSummary() : OrderSummaryInterface;
    
    public function setSummary(OrderSummaryInterface $summary);

    public function hasCurrentStatus() : bool;

    public function getCurrentStatus() : OrderStatusInterface;
    
    public function setCurrentStatus(OrderStatusInterface $currentStatus);
    
    public function setOrderStatusHistory(Collection $orderStatusHistory);
    
    public function getOrderStatusHistory() : Collection;
    
    public function addOrderStatusHistory(OrderStatusHistoryInterface $orderStatusHistory);
    
    public function getComment() : string;
    
    public function setComment(string $comment);
    
    public function getPayments() : Collection;
    
    public function setPayments(Collection $payments);
    
    public function addPayment(PaymentInterface $payment);
    
    public function acceptVisitor(OrderVisitorInterface $visitor);
    
    public function isEmpty() : bool;
}
