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

namespace WellCommerce\Bundle\CompanyBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface CompanyInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getShortName() : string;

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName);

    /**
     * @return CompanyAddressInterface
     */
    public function getAddress() : CompanyAddressInterface;

    /**
     * @param CompanyAddressInterface $address
     */
    public function setAddress(CompanyAddressInterface $address);
}
