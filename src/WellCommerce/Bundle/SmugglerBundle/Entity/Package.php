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

namespace WellCommerce\Bundle\SmugglerBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Package
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Package
{
    use Timestampable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $fullName;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $vendor;

    /**
     * @var string
     */
    protected $localVersion;

    /**
     * @var string
     */
    protected $remoteVersion;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getLocalVersion()
    {
        return $this->localVersion;
    }

    /**
     * @param string $localVersion
     */
    public function setLocalVersion($localVersion)
    {
        $this->localVersion = $localVersion;
    }

    /**
     * @return string
     */
    public function getRemoteVersion()
    {
        return $this->remoteVersion;
    }

    /**
     * @param string $remoteVersion
     */
    public function setRemoteVersion($remoteVersion)
    {
        $this->remoteVersion = $remoteVersion;
    }
}
