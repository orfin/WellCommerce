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

use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorage;

/**
 * Class ClientFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientFactory extends AbstractEntityFactory
{
    /**
     * @var ClientContactDetailsFactory
     */
    private $contactDetailsFactory;
    
    /**
     * @var ClientDetailsFactory
     */
    private $detailsFactory;
    
    /**
     * @var ClientBillingAddressFactory
     */
    private $billingAddressFactory;
    
    /**
     * @var ClientShippingAddressFactory
     */
    private $shippingAddressFactory;
    
    /**
     * @var ShopStorage
     */
    private $shopStorage;
    
    /**
     * ClientFactory constructor.
     *
     * @param ClientContactDetailsFactory  $contactDetailsFactory
     * @param ClientDetailsFactory         $detailsFactory
     * @param ClientBillingAddressFactory  $billingAddressFactory
     * @param ClientShippingAddressFactory $shippingAddressFactory
     * @param ShopStorage                  $shopStorage
     */
    public function __construct(
        ClientContactDetailsFactory $contactDetailsFactory,
        ClientDetailsFactory $detailsFactory,
        ClientBillingAddressFactory $billingAddressFactory,
        ClientShippingAddressFactory $shippingAddressFactory,
        ShopStorage $shopStorage
    ) {
        $this->contactDetailsFactory  = $contactDetailsFactory;
        $this->detailsFactory         = $detailsFactory;
        $this->billingAddressFactory  = $billingAddressFactory;
        $this->shippingAddressFactory = $shippingAddressFactory;
        $this->shopStorage            = $shopStorage;
    }
    
    public function create() : ClientInterface
    {
        $client = new Client();
        $client->setContactDetails($this->contactDetailsFactory->create());
        $client->setClientDetails($this->detailsFactory->create());
        $client->setBillingAddress($this->billingAddressFactory->create());
        $client->setShippingAddress($this->shippingAddressFactory->create());
        $client->setShop($this->shopStorage->getCurrentShop());
        $client->setClientGroup($this->shopStorage->getCurrentShop()->getClientGroup());
        
        return $client;
    }
}
