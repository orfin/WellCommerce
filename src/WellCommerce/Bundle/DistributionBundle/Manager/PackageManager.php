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

namespace WellCommerce\Bundle\DistributionBundle\Manager;

use ComposerRevisions\Revisions;
use Doctrine\ORM\EntityNotFoundException;
use Packagist\Api\Result\Package as RemotePackage;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\DistributionBundle\Entity\Package;
use WellCommerce\Bundle\DistributionBundle\Entity\PackageInterface;
use WellCommerce\Bundle\DistributionBundle\Helper\Package\PackageHelperInterface;

/**
 * Class PackageManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageManager extends AbstractManager
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
        $repository   = $this->getRepository();
        $localPackage = $repository->findOneBy(['fullName' => $remotePackage->getName()]);
        if (!$localPackage instanceof PackageInterface) {
            $this->addPackage($remotePackage);
        } else {
            $this->setPackageVersions($localPackage);
            $this->getDoctrineHelper()->getEntityManager()->flush();
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
        $this->setPackageVersions($package);
        $this->getDoctrineHelper()->getEntityManager()->persist($package);
    }

    /**
     * Returns console command arguments
     *
     * @param Request $request
     *
     * @return array
     */
    public function getConsoleCommandArguments(Request $request)
    {
        $port      = (int)$request->attributes->get('port');
        $package   = $request->attributes->get('id');
        $operation = $request->attributes->get('operation');

        return [
            'app/console',
            'wellcommerce:package:' . $operation,
            '--port=' . $port,
            '--package=' . $package
        ];
    }

    /**
     * Changes package info according to operation and data fetched from PackagistAPI
     *
     * @param Request $request
     *
     * @throws EntityNotFoundException
     */

    public function changePackageStatus(Request $request)
    {
        /**
         * @var $package \WellCommerce\Bundle\DistributionBundle\Entity\Package
         */
        $id         = $request->attributes->get('id');
        $em         = $this->getDoctrineHelper()->getEntityManager();
        $repository = $this->getRepository();
        $package    = $repository->find($id);

        if (null === $package) {
            throw new EntityNotFoundException($repository->getMetaData()->getName(), $id);
        }

        $this->setPackageVersions($package);

        $em->flush();
    }

    /**
     * @param PackageInterface $package
     */
    protected function setPackageVersions(PackageInterface $package)
    {
        $branch        = PackageHelperInterface::DEFAULT_BRANCH_VERSION;
        $remotePackage = $this->helper->getPackage($package->getFullName());
        $remoteVersion = $this->getPackageVersionReference($remotePackage->getVersions()[$branch]);

        if (isset(Revisions::$byName[$package->getFullName()])) {
            $localVersion = Revisions::$byName[$package->getFullName()];
        } else {
            $localVersion = null;
        }

        $package->setLocalVersion($localVersion);
        $package->setRemoteVersion($remoteVersion);
    }

    /**
     * Returns reference for particular package version
     *
     * @param RemotePackage\Version $version
     *
     * @return string
     */
    protected function getPackageVersionReference(RemotePackage\Version $version)
    {
        return $version->getSource()->getReference();
    }
}
