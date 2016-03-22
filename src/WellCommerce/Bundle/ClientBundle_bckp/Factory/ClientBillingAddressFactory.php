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

use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddress;
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientBillingAddressFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientBillingAddressFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientBillingAddressInterface::class;

    /**
     * @return ClientBillingAddressInterface
     */
    public function create() : ClientBillingAddressInterface
    {
        $address = new ClientBillingAddress();

        return $address;
    }
}
