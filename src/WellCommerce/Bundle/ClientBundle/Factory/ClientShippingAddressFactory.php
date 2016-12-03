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

use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddress;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorage;

/**
 * Class ClientShippingAddressFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientShippingAddressFactory extends AbstractEntityFactory
{
    /**
     * @var ShopStorage
     */
    private $shopStorage;
    
    /**
     * ClientShippingAddressFactory constructor.
     *
     * @param ShopStorage $storage
     */
    public function __construct(ShopStorage $storage)
    {
        $this->shopStorage = $storage;
    }
    
    public function create() : ClientShippingAddressInterface
    {
        $address = new ClientShippingAddress();
        $address->setFirstName('');
        $address->setLastName('');
        $address->setLine1('');
        $address->setLine2('');
        $address->setPostalCode('');
        $address->setState('');
        $address->setCity('');
        $address->setCountry($this->shopStorage->getCurrentShop()->getDefaultCountry());
        $address->setCopyBillingAddress(true);
        $address->setCompanyName('');
        
        return $address;
    }
}
