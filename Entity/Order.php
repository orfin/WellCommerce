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
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareTrait;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;

/**
 * Class Order
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Order implements OrderInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use ShippingMethodAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;
    use CouponAwareTrait;

    /**
     * @var int
     */
    protected $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionId($sessionId)
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
    public function getProducts()
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
    public function getOrderTotal()
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
    public function getProductTotal()
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
    public function getShippingTotal()
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
    public function getContactDetails()
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
    public function getBillingAddress()
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
    public function getShippingAddress()
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
    public function getTotals()
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
    public function getCurrentStatus()
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments()
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
    public function getShippingCostQuantity()
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
    public function getShippingCostWeight()
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
    public function getShippingCostGrossPrice()
    {
        return $this->productTotal->getGrossAmount();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency()
    {
        return $this->productTotal->getCurrency();
    }
}
