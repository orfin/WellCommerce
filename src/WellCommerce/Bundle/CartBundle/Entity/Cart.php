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
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsAwareTrait;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressAwareTrait;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareTrait;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Cart extends Order implements CartInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use PaymentMethodAwareTrait;
    use ShippingMethodAwareTrait;
    use ClientAwareTrait;
    use CouponAwareTrait;
    use ClientContactDetailsAwareTrait;
    use ClientBillingAddressAwareTrait;
    use ClientShippingAddressAwareTrait;

    /**
     * @var Collection
     */
    private $products;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var bool
     */
    private $copyAddress;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var CartProductTotalInterface
     */
    private $productTotal;

    /**
     * @var Collection
     */
    private $modifiers;

    /**
     * @var CartSummaryInterface
     */
    private $summary;

    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getCopyAddress() : bool
    {
        return $this->copyAddress;
    }

    public function setCopyAddress(bool $copyAddress)
    {
        $this->copyAddress = $copyAddress;
    }

    public function addProduct(CartProductInterface $cartProduct)
    {
        $this->products->add($cartProduct);
    }

    public function removeProduct(CartProductInterface $cartProduct)
    {
        $this->products->removeElement($cartProduct);
    }

    public function getProductTotal() : CartProductTotalInterface
    {
        return $this->productTotal;
    }

    public function setProductTotal(CartProductTotalInterface $productTotal)
    {
        $this->productTotal = $productTotal;
    }

    public function addModifier(CartModifierInterface $modifier)
    {
        $this->modifiers->set($modifier->getName(), $modifier);
    }

    public function hasModifier(string $name) : bool
    {
        return $this->modifiers->containsKey($name);
    }

    public function removeModifier(string $name)
    {
        $this->modifiers->remove($name);
    }

    public function getModifier(string $name) : CartModifierInterface
    {
        return $this->modifiers->get($name);
    }

    public function getModifiers() : Collection
    {
        return $this->modifiers;
    }

    public function setModifiers(Collection $modifiers)
    {
        $this->modifiers = $modifiers;
    }

    public function getProducts() : Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    public function acceptVisitor(CartVisitorInterface $visitor)
    {
        $visitor->visitCart($this);
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    public function getSummary() : CartSummaryInterface
    {
        return $this->summary;
    }

    public function setSummary(CartSummaryInterface $summary)
    {
        $this->summary = $summary;
    }

    public function isEmpty() : bool
    {
        return 0 === $this->productTotal->getQuantity();
    }
}
