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

namespace WellCommerce\Bundle\DistributionBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface PackageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PackageInterface extends EntityInterface, TimestampableInterface
{
    public function getFullName(): string;
    
    public function setFullName(string $fullName);
    
    public function getName(): string;
    
    public function setName(string $name);
    
    public function getVendor(): string;
    
    public function setVendor(string $vendor);
    
    public function getLocalVersion(): string;
    
    public function setLocalVersion(string $localVersion);
    
    public function getRemoteVersion(): string;
    
    public function setRemoteVersion(string $remoteVersion);
}
