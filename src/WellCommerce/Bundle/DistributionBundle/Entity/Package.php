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
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityTrait;

/**
 * Class Package
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Package implements PackageInterface
{
    use IdentifiableEntityTrait;
    use Timestampable;

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
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * {@inheritdoc}
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalVersion()
    {
        return $this->localVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocalVersion($localVersion)
    {
        $this->localVersion = $localVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function getRemoteVersion()
    {
        return $this->remoteVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setRemoteVersion($remoteVersion)
    {
        $this->remoteVersion = $remoteVersion;
    }
}
