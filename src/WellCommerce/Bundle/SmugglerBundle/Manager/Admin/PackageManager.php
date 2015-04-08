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

namespace WellCommerce\Bundle\SmugglerBundle\Manager\Admin;

use Packagist\Api\Result\Package as RemotePackage;
use WellCommerce\Bundle\AdminBundle\Manager\AbstractAdminManager;
use WellCommerce\Bundle\SmugglerBundle\Entity\Package;
use WellCommerce\Bundle\SmugglerBundle\Helper\PackageHelperInterface;

/**
 * Class PackageManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageManager extends AbstractAdminManager
{
    /**
     * @var PackageHelperInterface
     */
    protected $helper;

    /**
     * @param PackageHelperInterface $helper
     */
    public function setHelper(PackageHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Searches for all packages of particular type and adds them to Smuggler
     */
    public function syncPackages($type)
    {
        $criteria      = ['type' => $type];
        $em            = $this->getDoctrineHelper()->getEntityManager();
        $searchResults = $this->helper->getPackages($criteria);
        foreach ($searchResults as $result) {
            $package = $this->helper->getPackage($result);
            $this->syncPackage($package);
        }

        $em->flush();
    }

    /**
     * Syncs single remote package
     *
     * @param RemotePackage $remotePackage
     */
    protected function syncPackage(RemotePackage $remotePackage)
    {
        $repository = $this->getRepository();
        $result     = $repository->findOneBy(['fullName' => $remotePackage->getName()]);
        if (null === $result) {
            $this->addPackage($remotePackage);
        }
    }

    /**
     * Adds new package to info to Smuggler
     *
     * @param RemotePackage $remotePackage
     */
    protected function addPackage(RemotePackage $remotePackage)
    {
        list($vendor, $name) = explode('/', $remotePackage->getName());
        $package = new Package();
        $package->setFullName($remotePackage->getName());
        $package->setName($name);
        $package->setVendor($vendor);
        $this->getDoctrineHelper()->getEntityManager()->persist($package);
    }
}
