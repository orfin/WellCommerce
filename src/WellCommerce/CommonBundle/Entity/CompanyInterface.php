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

namespace WellCommerce\CommonBundle\Entity;

use WellCommerce\CoreBundle\Entity\BlameableInterface;
use WellCommerce\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface CompanyInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyInterface extends TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getShortName();

    /**
     * @param string $shortName
     */
    public function setShortName($shortName);

    /**
     * @return CompanyAddressInterface
     */
    public function getAddress();

    /**
     * @param CompanyAddressInterface $address
     */
    public function setAddress(CompanyAddressInterface $address);
}
