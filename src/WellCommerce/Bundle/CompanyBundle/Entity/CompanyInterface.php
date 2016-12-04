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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface CompanyInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    public function getName(): string;
    
    public function setName(string $name);
    
    public function getShortName(): string;
    
    public function setShortName(string $shortName);
    
    public function getAddress(): CompanyAddress;
    
    public function setAddress(CompanyAddress $address);
}
