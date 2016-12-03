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
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientDetailsAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressAwareTrait;
use WellCommerce\Bundle\CoreBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\OrderBundle\Entity\Extra\OrderExtraTrait;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;
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
    use IdentifiableTrait;
    use TimestampableTrait;
    use ShopAwareTrait;
    use ShippingMethodAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;
    use ClientDetailsAwareTrait;
    use ClientContactDetailsAwareTrait;
    use ClientBillingAddressAwareTrait;
    use ClientShippingAddressAwareTrait;
    use CouponAwareTrait;
    use OrderExtraTrait;
    
    /**
     * @var bool
     */
    protected $confirmed;
    
    /**
     * @var string
     */
    protected $number;
    
    /**
     * @var Collection|OrderProductInterface[]
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
     * @var Collection|PaymentInterface[]
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
     * @var Collection|OrderStatusHistoryInterface[]
     */
    protected $orderStatusHistory;
    
    /**
     * @var OrderProductTotalInterface
     */
    protected $productTotal;
    
    /**
     * @var Collection|OrderModifierInterface[]
     */
    protected $modifiers;
    
    /**
     * @var OrderSummary
     */
    protected $summary;
    
    /**
     * @var string|null
     */
    protected $shippingMethodOption;
    
    /**
     * @var string
     */
    protected $comment;
    
    /**
     * @var bool
     */
    protected $issueInvoice;
    
    /**
     * @var bool
     */
    protected $conditionsAccepted;
    
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }
    
    public function setConfirmed(bool $confirmed)
    {
        $this->confirmed = $confirmed;
    }
    
    public function getNumber()
    {
        return $this->number;
    }
    
    public function setNumber(string $number)
    {
        $this->number = $number;
    }
    
    public function getCurrency(): string
    {
        return $this->currency;
    }
    
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    
    public function getCurrencyRate(): float
    {
        return $this->currencyRate;
    }
    
    public function setCurrencyRate(float $currencyRate)
    {
        $this->currencyRate = $currencyRate;
    }
    
    public function getSessionId(): string
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
        $orderProduct->removeFromOrder();
    }
    
    public function getProducts(): Collection
    {
        return $this->products;
    }
    
    public function setProducts(Collection $products)
    {
        if ($this->products instanceof Collection) {
            $this->products->map(function (OrderProductInterface $orderProduct) use ($products) {
                if (false === $products->contains($orderProduct)) {
                    $this->products->removeElement($orderProduct);
                }
            });
        }
        
        $this->products = $products;
    }
    
    public function getProductTotal(): OrderProductTotalInterface
    {
        return $this->productTotal;
    }
    
    public function setProductTotal(OrderProductTotalInterface $productTotal)
    {
        $this->productTotal = $productTotal;
    }
    
    public function addModifier(OrderModifierInterface $modifier)
    {
        $this->modifiers->set($modifier->getName(), $modifier);
    }
    
    public function hasModifier(string $name): bool
    {
        return $this->modifiers->containsKey($name);
    }
    
    public function removeModifier(string $name)
    {
        $this->modifiers->remove($name);
    }
    
    public function getModifier(string $name): OrderModifierInterface
    {
        return $this->modifiers->get($name);
    }
    
    public function getModifiers(): Collection
    {
        return $this->modifiers;
    }
    
    public function setModifiers(Collection $modifiers)
    {
        $this->modifiers = $modifiers;
    }
    
    public function getSummary(): OrderSummary
    {
        return $this->summary;
    }
    
    public function setSummary(OrderSummary $summary)
    {
        $this->summary = $summary;
    }
    
    public function hasCurrentStatus(): bool
    {
        return $this->currentStatus instanceof OrderStatusInterface;
    }
    
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }
    
    public function setCurrentStatus(OrderStatusInterface $currentStatus = null)
    {
        $this->currentStatus = $currentStatus;
    }
    
    public function setOrderStatusHistory(Collection $orderStatusHistory)
    {
        $this->orderStatusHistory = $orderStatusHistory;
    }
    
    public function getOrderStatusHistory(): Collection
    {
        return $this->orderStatusHistory;
    }
    
    public function addOrderStatusHistory(OrderStatusHistoryInterface $orderStatusHistory)
    {
        $this->orderStatusHistory->add($orderStatusHistory);
    }
    
    public function getComment(): string
    {
        return $this->comment;
    }
    
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
    
    public function getPayments(): Collection
    {
        return $this->payments;
    }
    
    public function setPayments(Collection $payments)
    {
        $this->payments = $payments;
    }
    
    public function addPayment(PaymentInterface $payment)
    {
        $this->payments[] = $payment;
    }
    
    public function acceptVisitor(OrderVisitorInterface $visitor)
    {
        $visitor->visitOrder($this);
    }
    
    public function isEmpty(): bool
    {
        return 0 === $this->productTotal->getQuantity();
    }
    
    /**
     * @return null|string
     */
    public function getShippingMethodOption()
    {
        return $this->shippingMethodOption;
    }
    
    /**
     * @param null|string $shippingMethodOption
     */
    public function setShippingMethodOption($shippingMethodOption)
    {
        $this->shippingMethodOption = $shippingMethodOption;
    }
    
    /**
     * @return boolean
     */
    public function isConditionsAccepted(): bool
    {
        return $this->conditionsAccepted;
    }
    
    /**
     * @param boolean $conditionsAccepted
     */
    public function setConditionsAccepted(bool $conditionsAccepted)
    {
        $this->conditionsAccepted = $conditionsAccepted;
    }
    
    /**
     * @return boolean
     */
    public function isIssueInvoice(): bool
    {
        return $this->issueInvoice;
    }
    
    /**
     * @param boolean $issueInvoice
     */
    public function setIssueInvoice(bool $issueInvoice)
    {
        $this->issueInvoice = $issueInvoice;
    }
}
