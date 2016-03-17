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

namespace WellCommerce\Bundle\CompanyBundle\Factory;

use WellCommerce\Bundle\CompanyBundle\Entity\CompanyAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CompanyAddressFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyAddressFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CompanyAddressInterface::class;

    /**
     * @return CompanyAddressInterface
     */
    public function create() : CompanyAddressInterface
    {
        /** @var $address CompanyAddressInterface */
        $address = $this->init();

        return $address;
    }
}
