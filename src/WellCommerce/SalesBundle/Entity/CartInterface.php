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

namespace WellCommerce\SalesBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\ClientBundle\Entity\ClientAwareInterface;
use WellCommerce\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\CommonBundle\Entity\ShopAwareInterface;
use WellCommerce\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\PromotionBundle\Entity\CouponAwareInterface;
use WellCommerce\SalesBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\SalesBundle\Visitor\CartVisitorInterface;

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
    CouponAwareInterface,
    ShippingCalculatorSubjectInterface
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
     * @return boolean
     */
    public function getCopyAddress();

    /**
     * @param boolean $copyAddress
     */
    public function setCopyAddress($copyAddress);

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
     * @return null|\WellCommerce\CoreBundle\Entity\Price
     */
    public function getShippingCost();

    /**
     * @return bool
     */
    public function isEmpty();
}
