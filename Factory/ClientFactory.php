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

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientInterface::class;

    /**
     * @return ClientInterface
     */
    public function create() : ClientInterface
    {
        /** @var $client ClientInterface */
        $client = $this->init();
        $client->setContactDetails($this->get('client_contact_details.factory')->create());
        $client->setClientDetails($this->get('client_details.factory')->create());
        $client->setBillingAddress($this->get('client_billing_address.factory')->create());
        $client->setShippingAddress($this->get('client_shipping_address.factory')->create());

        return $client;
    }
}
