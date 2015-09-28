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

/**
 * Interface ClientAddressAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientAddressAwareInterface
{
    /**
     * @return Collection
     */
    public function getAddresses();

    /**
     * @param Collection $addresses
     */
    public function setAddresses(Collection $addresses);

    /**
     * @param ClientAddress $address
     */
    public function addAddress(ClientAddressInterface $address);
}
