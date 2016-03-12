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
namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Cart extends AbstractEntity implements CartInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;
    use CouponAwareTrait;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var bool
     */
    protected $copyAddress;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var CartTotals
     */
    protected $totals;

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
     * @var ShippingMethodCostInterface
     */
    protected $shippingMethodCost;

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
    public function getCopyAddress() : bool
    {
        return $this->copyAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setCopyAddress(bool $copyAddress)
    {
        $this->copyAddress = $copyAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(CartProductInterface $cartProduct)
    {
        $this->products->add($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(CartProductInterface $cartProduct)
    {
        $this->products->removeElement($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotals() : CartTotalsInterface
    {
        return $this->totals;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotals(CartTotalsInterface $cartTotals)
    {
        $this->totals = $cartTotals;
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
    public function acceptVisitor(CartVisitorInterface $visitor)
    {
        $visitor->visitCart($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethodCost()
    {
        return $this->shippingMethodCost;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethodCost(ShippingMethodCostInterface $shippingMethodCost = null)
    {
        $this->shippingMethodCost = $shippingMethodCost;
    }

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
    public function getShippingCostQuantity() : int
    {
        return $this->totals->getQuantity();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostWeight() : float
    {
        return $this->totals->getWeight();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostGrossPrice() : float
    {
        return $this->totals->getGrossPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency() : string
    {
        return $this->getCurrency();
    }

    /**
     * {@inheritdoc}
     */
    public function hasMethods() : bool
    {
        return (
            $this->getShippingMethodCost() instanceof ShippingMethodCostInterface
            && $this->getPaymentMethod() instanceof PaymentMethodInterface
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCost()
    {
        if ($this->getShippingMethodCost() instanceof ShippingMethodCostInterface) {
            return $this->getShippingMethodCost()->getCost();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() : bool
    {
        return 0 === $this->products->count();
    }
}
