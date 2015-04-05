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

use Packagist\Api\Client;
use Packagist\Api\Result\Package as RemotePackage;
use WellCommerce\Bundle\AdminBundle\Manager\AbstractAdminManager;
use WellCommerce\Bundle\SmugglerBundle\Entity\Package;

/**
 * Class PackageManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageManager extends AbstractAdminManager
{
    const DEFAULT_PACKAGE_TYPE = 'wellcommerce-plugin';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Searches for all packages of particular type and adds them to Smuggler
     */
    public function syncPackages($type)
    {
        $em            = $this->getDoctrineHelper()->getEntityManager();
        $searchResults = $this->getPackages($type);
        foreach ($searchResults as $result) {
            $package = $this->client->get($result);
            $this->syncPackage($package);
        }

        $em->flush();
    }

    /**
     * Returns all packages by type
     *
     * @param string $type
     *
     * @return array
     */
    protected function getPackages($type)
    {
        $criteria = ['type' => $type];

        return $this->client->all($criteria);
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
