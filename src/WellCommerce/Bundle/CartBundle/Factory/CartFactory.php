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

namespace WellCommerce\Bundle\CartBundle\Factory;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductTotalInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartSummaryInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CartFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartFactory extends AbstractEntityFactory
{
    protected $supportsInterface = CartInterface::class;

    public function create() : CartInterface
    {
        /** @var $cart CartInterface */
        $cart = $this->init();
        $cart->setProducts($this->createEmptyCollection());
        $cart->setProductTotal($this->createCartProductTotal());
        $cart->setModifiers($this->createEmptyCollection());
        $cart->setCopyAddress(true);
        $cart->setCurrency($this->getRequestHelper()->getCurrentCurrency());
        $cart->setSessionId($this->getRequestHelper()->getSessionId());
        $cart->setSummary($this->createCartSummary());
        $cart->setContactDetails($this->createContactDetails());
        $cart->setBillingAddress($this->createBillingAddress());
        $cart->setShippingAddress($this->createShippingAddress());

        return $cart;
    }

    private function createContactDetails() : ClientContactDetailsInterface
    {
        return $this->get('client_contact_details.factory')->create();
    }

    private function createBillingAddress() : ClientBillingAddressInterface
    {
        return $this->get('client_billing_address.factory')->create();
    }

    private function createShippingAddress() : ClientShippingAddressInterface
    {
        return $this->get('client_shipping_address.factory')->create();
    }

    private function createCartProductTotal() : CartProductTotalInterface
    {
        return $this->get('cart_product_total.factory')->create();
    }

    private function createCartSummary() : CartSummaryInterface
    {
        return $this->get('cart_summary.factory')->create();
    }
}
