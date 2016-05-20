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

use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientShippingAddressFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientShippingAddressFactory extends AbstractEntityFactory
{
    protected $supportsInterface = ClientShippingAddressInterface::class;
    
    public function create() : ClientShippingAddressInterface
    {
        /** @var ClientShippingAddressInterface $address */
        $address = $this->init();
        $address->setFirstName('');
        $address->setLastName('');
        $address->setLine1('');
        $address->setLine2('');
        $address->setPostalCode('');
        $address->setState('');
        $address->setCity('');
        $address->setCountry($this->getDefaultShop()->getDefaultCountry());
        $address->setCopyBillingAddress(true);
        
        return $address;
    }
}
