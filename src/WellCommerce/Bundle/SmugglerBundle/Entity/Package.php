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

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class Package
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="smuggler_package")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\SmugglerBundle\Repository\PackageRepository")
 */
class Package
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=false, unique=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=255, nullable=false)
     */
    private $vendor;

    /**
     * @var string
     *
     * @ORM\Column(name="local_version", type="string", length=12, nullable=true)
     */
    private $localVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="remote_version", type="string", length=12, nullable=true)
     */
    private $remoteVersion;

    /**
     * Get id.
     *
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
