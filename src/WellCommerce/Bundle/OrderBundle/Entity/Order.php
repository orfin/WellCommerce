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
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareTrait;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;

/**
 * Class Order
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Order extends AbstractEntity implements OrderInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use ShippingMethodAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;
    use CouponAwareTrait;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @var Price
     */
    protected $orderTotal;

    /**
     * @var Price
     */
    protected $productTotal;

    /**
     * @var Price
     */
    protected $shippingTotal;

    /**
     * @var Collection
     */
    protected $totals;

    /**
     * @var Collection
     */
    protected $payments;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var OrderStatusInterface
     */
    protected $currentStatus;

    /**
     * @var Collection
     */
    protected $orderStatusHistory;
    
    /**
     * @var ClientContactDetailsInterface
     */
    protected $contactDetails;

    /**
     * @var ClientBillingAddressInterface
     */
    protected $billingAddress;

    /**
     * @var ClientShippingAddressInterface
     */
    protected $shippingAddress;
    
    /**
     * @var string
     */
    protected $comment;
    
    /**
     * {@inheritdoc}
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(OrderProductInterface $orderProduct)
    {
        $this->products->add($orderProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(OrderProductInterface $orderProduct)
    {
        $this->products->removeElement($orderProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts() : Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @return OrderTotal
     */
    public function getOrderTotal() : OrderTotal
    {
        return $this->orderTotal;
    }

    /**
     * @param OrderTotal $orderTotal
     */
    public function setOrderTotal(OrderTotal $orderTotal)
    {
        $this->orderTotal = $orderTotal;
    }

    /**
     * @return OrderTotal
     */
    public function getProductTotal() : OrderTotal
    {
        return $this->productTotal;
    }

    /**
     * @param OrderTotal $productTotal
     */
    public function setProductTotal(OrderTotal $productTotal)
    {
        $this->productTotal = $productTotal;
    }

    /**
     * @return OrderTotal
     */
    public function getShippingTotal() : OrderTotal
    {
        return $this->shippingTotal;
    }

    /**
     * @param OrderTotal $shippingTotal
     */
    public function setShippingTotal(OrderTotal $shippingTotal)
    {
        $this->shippingTotal = $shippingTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactDetails() : ClientContactDetailsInterface
    {
        return $this->contactDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress() : ClientBillingAddressInterface
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddress() : ClientShippingAddressInterface
    {
        return $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotals() : Collection
    {
        return $this->totals;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotals(Collection $totals)
    {
        $this->totals = $totals;
    }

    /**
     * {@inheritdoc}
     */
    public function addTotal(OrderTotalDetailInterface $orderTotal)
    {
        $this->totals->add($orderTotal);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStatus() : OrderStatusInterface
    {
        return $this->currentStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentStatus(OrderStatusInterface $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderStatusHistory(Collection $orderStatusHistory)
    {
        $this->orderStatusHistory = $orderStatusHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderStatusHistory() : Collection
    {
        return $this->orderStatusHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function addOrderStatusHistory(OrderStatusHistoryInterface $orderStatusHistory)
    {
        $this->orderStatusHistory->add($orderStatusHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments() : Collection
    {
        return $this->payments;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayments(Collection $payments)
    {
        $this->payments = $payments;
    }

    /**
     * {@inheritdoc}
     */
    public function addPayment(PaymentInterface $payment)
    {
        $this->payments[] = $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostQuantity() : int
    {
        $quantity = 0;
        $this->products->map(function (OrderProduct $orderProduct) use (&$quantity) {
            $quantity += $orderProduct->getQuantity();
        });

        return $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostWeight() : float
    {
        $weight = 0;
        $this->products->map(function (OrderProduct $orderProduct) use (&$weight) {
            $weight += $orderProduct->getQuantity() * $orderProduct->getWeight();
        });

        return $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostGrossPrice() : float
    {
        return $this->productTotal->getGrossAmount();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency() : string
    {
        return $this->productTotal->getCurrency();
    }
}
