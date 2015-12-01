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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\ClientAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\AppBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\AppBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\AppBundle\Entity\CouponAwareInterface;
use WellCommerce\Bundle\AppBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\Bundle\AppBundle\Service\Cart\Visitor\CartVisitorInterface;

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
     * @return null|\WellCommerce\Bundle\AppBundle\Entity\Price
     */
    public function getShippingCost();

    /**
     * @return bool
     */
    public function isEmpty();
}
