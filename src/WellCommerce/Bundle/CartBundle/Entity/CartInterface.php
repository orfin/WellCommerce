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
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetailsAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopAwareInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;

/**
 * Interface CartInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartInterface extends
    ShopAwareInterface,
    PaymentMethodAwareInterface,
    ClientAwareInterface,
    TimestampableInterface,
    ContactDetailsAwareInterface
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
     * @param CartProductInterface $cartProduct
     */
    public function addProduct(CartProductInterface $cartProduct);

    /**
     * @param CartProduct $cartProduct
     */
    public function removeProduct(CartProductInterface $cartProduct);

    /**
     * @return CartTotals
     */
    public function getTotals();

    /**
     * @param CartTotals $cartTotals
     */
    public function setTotals(CartTotalsInterface $cartTotals);

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
     * @param CartVisitorInterface $visitor
     */
    public function acceptVisitor(CartVisitorInterface $visitor);

    /**
     * @return null|ShippingMethodCostInterface
     */
    public function getShippingMethodCost();

    /**
     * @param null|ShippingMethodCostInterface $shippingMethodCost
     */
    public function setShippingMethodCost(ShippingMethodCostInterface $shippingMethodCost = null);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

    /**
     * Checks whether cart has shipping and payment method
     *
     * @return bool
     */
    public function hasMethods();

    /**
     * @return bool
     */
    public function isEmpty();
}
