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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetailsAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\MultiStoreAwareInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareInterface;

/**
 * Interface CartInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartInterface extends
    MultiStoreAwareInterface,
    PaymentMethodAwareInterface,
    ShippingMethodAwareInterface,
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
     * @param CartProduct $cartProduct
     */
    public function addProduct(CartProduct $cartProduct);

    /**
     * @param CartProduct $cartProduct
     */
    public function removeProduct(CartProduct $cartProduct);

    /**
     * @return CartTotals
     */
    public function getTotals();

    /**
     * @param CartTotals $cartTotals
     */
    public function setTotals(CartTotalsInterface $cartTotals);

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartProductInterface[]
     */
    public function getProducts();

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products);

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
     * @return bool
     */
    public function isEmpty();
}
