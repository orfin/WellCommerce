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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientFactory extends AbstractEntityFactory
{
    public function create() : ClientInterface
    {
        /** @var $client ClientInterface */
        $client = $this->init();
        $client->setContactDetails($this->createClientContactDetails());
        $client->setClientDetails($this->createClientDetails());
        $client->setBillingAddress($this->createBillingAddress());
        $client->setShippingAddress($this->createShippingAddress());
        $client->setShop($this->getDefaultShop());
        $client->setClientGroup($this->getDefaultShop()->getClientGroup());
        
        return $client;
    }
    
    private function createClientContactDetails() : ClientContactDetailsInterface
    {
        return $this->get('client_contact_details.factory')->create();
    }
    
    private function createClientDetails() : ClientDetailsInterface
    {
        return $this->get('client_details.factory')->create();
    }
    
    private function createBillingAddress() : ClientBillingAddressInterface
    {
        return $this->get('client_billing_address.factory')->create();
    }
    
    private function createShippingAddress() : ClientShippingAddressInterface
    {
        return $this->get('client_shipping_address.factory')->create();
    }
}
