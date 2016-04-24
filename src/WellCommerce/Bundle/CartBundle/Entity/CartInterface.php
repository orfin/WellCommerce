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
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsAwareInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareInterface;

/**
 * Interface CartInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartInterface extends OrderInterface
{
    public function getSessionId() : string;

    public function setSessionId(string $sessionId);

    public function getCopyAddress() : bool;

    public function setCopyAddress(bool $copyAddress);

    public function addProduct(CartProductInterface $cartProduct);

    public function removeProduct(CartProductInterface $cartProduct);

    public function getProductTotal() : CartProductTotalInterface;

    public function setProductTotal(CartProductTotalInterface $productTotal);

    public function addModifier(CartModifierInterface $modifier);

    public function getModifier(string $name) : CartModifierInterface;

    public function hasModifier(string $name) : bool;

    public function removeModifier(string $name);

    public function getModifiers() : Collection;

    public function setModifiers(Collection $modifiers);
    
    public function getProducts() : Collection;

    public function setProducts(Collection $products);

    public function acceptVisitor(CartVisitorInterface $visitor);

    public function getCurrency() : string;

    public function setCurrency(string $currency);

    public function getSummary() : CartSummaryInterface;

    public function setSummary(CartSummaryInterface $summary);

    public function isEmpty() : bool;
}
