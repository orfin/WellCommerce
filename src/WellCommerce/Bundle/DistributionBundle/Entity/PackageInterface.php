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

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface PackageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PackageInterface extends EntityInterface, TimestampableInterface
{
    /**
     * @return string
     */
    public function getFullName();
    
    /**
     * @param string $fullName
     */
    public function setFullName($fullName);
    
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
    public function getVendor();
    
    /**
     * @param string $vendor
     */
    public function setVendor($vendor);
    
    /**
     * @return string
     */
    public function getLocalVersion();
    
    /**
     * @param string $localVersion
     */
    public function setLocalVersion($localVersion);
    
    /**
     * @return string
     */
    public function getRemoteVersion();
    
    /**
     * @param string $remoteVersion
     */
    public function setRemoteVersion($remoteVersion);
}
