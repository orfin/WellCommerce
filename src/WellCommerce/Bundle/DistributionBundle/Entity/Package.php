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

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Package
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Package implements PackageInterface
{
    use IdentifiableTrait;
    use Timestampable;
    
    protected $fullName      = '';
    protected $name          = '';
    protected $vendor        = '';
    protected $localVersion  = '';
    protected $remoteVersion = '';
    
    public function getFullName(): string
    {
        return $this->fullName;
    }
    
    public function setFullName(string $fullName)
    {
        $this->fullName = $fullName;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getVendor(): string
    {
        return $this->vendor;
    }
    
    public function setVendor(string $vendor)
    {
        $this->vendor = $vendor;
    }

    public function getLocalVersion(): string
    {
        return $this->localVersion;
    }
    
    public function setLocalVersion(string $localVersion)
    {
        $this->localVersion = $localVersion;
    }
    
    public function getRemoteVersion(): string
    {
        return $this->remoteVersion;
    }
    
    public function setRemoteVersion(string $remoteVersion)
    {
        $this->remoteVersion = $remoteVersion;
    }
}
