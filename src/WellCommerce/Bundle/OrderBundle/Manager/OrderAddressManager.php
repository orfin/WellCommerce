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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;

/**
 * Class OrderAddressManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderAddressManager extends AbstractOrderManager
{
    public function setAddresses()
    {
        $client = $this->getClient();
        $cart   = $this->getCartContext()->getCurrentCart();

        if ($client instanceof ClientInterface) {
            $cart->setBillingAddress($client->getBillingAddress());
            $cart->setShippingAddress($client->getShippingAddress());
            $cart->setContactDetails($client->getContactDetails());
        }
    }
}
