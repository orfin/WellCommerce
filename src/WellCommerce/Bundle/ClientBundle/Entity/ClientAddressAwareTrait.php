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

namespace WellCommerce\Bundle\ClientBundle\Entity;


use Doctrine\Common\Collections\Collection;

trait ClientAddressAwareTrait
{
    /**
     * @var Collection
     */
    protected $addresses;

    /**
     * @return Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Collection $addresses
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @param ClientAddress $address
     */
    public function addAddress(ClientAddressInterface $address)
    {
        $this->addresses[] = $address;
    }
}
