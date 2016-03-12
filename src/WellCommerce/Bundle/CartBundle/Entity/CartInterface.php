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
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;

/**
 * Interface CartInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartInterface extends
    EntityInterface,
    ShopAwareInterface,
    PaymentMethodAwareInterface,
    ClientAwareInterface,
    TimestampableInterface,
    CouponAwareInterface,
    ShippingCalculatorSubjectInterface
{
    /**
     * @return string
     */
    public function getSessionId() : string;

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId);

    /**
     * @return boolean
     */
    public function getCopyAddress() : bool;

    /**
     * @param boolean $copyAddress
     */
    public function setCopyAddress(bool $copyAddress);

    /**
     * @param CartProductInterface $cartProduct
     */
    public function addProduct(CartProductInterface $cartProduct);

    /**
     * @param CartProduct $cartProduct
     */
    public function removeProduct(CartProductInterface $cartProduct);

    /**
     * @return CartTotalsInterface
     */
    public function getTotals() : CartTotalsInterface;

    /**
     * @param CartTotals $cartTotals
     */
    public function setTotals(CartTotalsInterface $cartTotals);

    /**
     * @return Collection
     */
    public function getProducts() : Collection;

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products);

    /**
     * @return ClientContactDetailsInterface
     */
    public function getContactDetails() : ClientContactDetailsInterface;

    /**
     * @param ClientContactDetailsInterface $contactDetails
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails);

    /**
     * @return ClientBillingAddressInterface
     */
    public function getBillingAddress() : ClientBillingAddressInterface;

    /**
     * @param ClientBillingAddressInterface $billingAddress
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress);

    /**
     * @return ClientShippingAddressInterface
     */
    public function getShippingAddress() : ClientShippingAddressInterface;

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
    public function getCurrency() : string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency);

    /**
     * Checks whether cart has shipping and payment method
     *
     * @return bool
     */
    public function hasMethods() : bool;

    /**
     * @return Price
     */
    public function getShippingCost();

    /**
     * @return bool
     */
    public function isEmpty() : bool;
}
