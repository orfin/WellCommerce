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
use WellCommerce\Bundle\CartBundle\Entity\CartAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressAwareTrait;
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
    use ClientContactDetailsAwareTrait;
    use ClientBillingAddressAwareTrait;
    use ClientShippingAddressAwareTrait;
    use CouponAwareTrait;
    
    /**
     * @var Collection
     */
    protected $products;
    
    /**
     * @var string
     */
    protected $currency;
    
    /**
     * @var float
     */
    protected $currencyRate;

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
     * @var Collection
     */
    private $modifiers;
    
    /**
     * @var OrderSummaryInterface
     */
    private $summary;
    
    /**
     * @var string
     */
    protected $comment;
    
    public function getCurrency() : string
    {
        return $this->currency;
    }
    
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    
    public function getCurrencyRate() : float
    {
        return $this->currencyRate;
    }
    
    public function setCurrencyRate(float $currencyRate)
    {
        $this->currencyRate = $currencyRate;
    }
    
    public function getSessionId() : string
    {
        return $this->sessionId;
    }
    
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }
    
    public function addProduct(OrderProductInterface $orderProduct)
    {
        $this->products->add($orderProduct);
    }
    
    public function removeProduct(OrderProductInterface $orderProduct)
    {
        $this->products->removeElement($orderProduct);
    }
    
    public function getProducts() : Collection
    {
        return $this->products;
    }
    
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    public function getSummary() : OrderSummaryInterface
    {
        return $this->summary;
    }

    public function setSummary(OrderSummaryInterface $summary)
    {
        $this->summary = $summary;
    }

    public function getTotals() : Collection
    {
        return $this->totals;
    }
    
    public function setTotals(Collection $totals)
    {
        $this->totals = $totals;
    }
    
    public function addTotal(OrderTotalDetailInterface $orderTotal)
    {
        $this->totals->add($orderTotal);
    }
    
    public function getCurrentStatus() : OrderStatusInterface
    {
        return $this->currentStatus;
    }
    
    public function setCurrentStatus(OrderStatusInterface $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }
    
    public function setOrderStatusHistory(Collection $orderStatusHistory)
    {
        $this->orderStatusHistory = $orderStatusHistory;
    }
    
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
        $this->products->map(function (OrderProductInterface $orderProduct) use (&$quantity) {
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
        $this->products->map(function (OrderProductInterface $orderProduct) use (&$weight) {
            $weight += $orderProduct->getQuantity() * $orderProduct->getWeight();
        });
        
        return $weight;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getShippingCostGrossPrice() : float
    {
        $totalGrossPrice = 0;
        $this->products->map(function (OrderProductInterface $orderProduct) use (&$totalGrossPrice) {
            $totalGrossPrice += $orderProduct->getSellPrice()->getGrossAmount();
        });
        
        return $totalGrossPrice;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency() : string
    {
        return $this->currency;
    }
}
