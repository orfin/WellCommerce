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

use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ClientAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientAddressInterface extends TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return AddressInterface
     */
    public function getAddress();

    /**
     * @param AddressInterface $address
     */
    public function setAddress(AddressInterface $address);

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client);

    /**
     * @return ClientInterface
     */
    public function getClient();
}
