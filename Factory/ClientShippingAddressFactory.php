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
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientShippingAddressFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientShippingAddressFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientShippingAddressFactory::class;

    /**
     * @return ClientShippingAddressInterface
     */
    public function create() : ClientShippingAddressInterface
    {
        $address = new ClientShippingAddress();
        
        return $address;
    }
}
