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

namespace WellCommerce\Bundle\OrderBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;

/**
 * Class OrderAddressManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderAddressManager extends AbstractFrontManager
{
    public function setAddresses()
    {
        $client = $this->getClient();
        $cart   = $this->getCartContext()->getCurrentCart();;

        if (null !== $client) {
            $this->copyBillingAddress($client, $cart);
            $this->copyShippingAddress($client, $cart);
            $this->copyContactDetails($client, $cart);
        }
    }

    /**
     * Copies the client's billing address to cart
     *
     * @param ClientInterface $client
     * @param CartInterface   $cart
     */
    protected function copyBillingAddress(ClientInterface $client, CartInterface $cart)
    {
        $cart->setBillingAddress($client->getBillingAddress());
    }

    /**
     * Copies the client's shipping address to cart
     *
     * @param ClientInterface $client
     * @param CartInterface   $cart
     */
    protected function copyShippingAddress(ClientInterface $client, CartInterface $cart)
    {
        $cart->setShippingAddress($client->getShippingAddress());
    }

    /**
     * Copies the client's contact details to cart
     *
     * @param ClientInterface $client
     * @param CartInterface   $cart
     */
    protected function copyContactDetails(ClientInterface $client, CartInterface $cart)
    {
        $cart->setContactDetails($client->getContactDetails());
    }
}
