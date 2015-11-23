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

namespace WellCommerce\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\FileLocator;
use WellCommerce\AppBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadAdminMenuData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadAdminMenuData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $reflection = new \ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $locator    = new FileLocator($directory . '/../../Resources/config/admin_menu');

        $importer = $this->container->get('admin_menu.importer.xml');

        $importer->import('catalog.xml', $locator);
        $importer->import('cms.xml', $locator);
        $importer->import('configuration.xml', $locator);
        $importer->import('crm.xml', $locator);
        $importer->import('dashboard.xml', $locator);
        $importer->import('integration.xml', $locator);
        $importer->import('layout.xml', $locator);
        $importer->import('promotions.xml', $locator);
        $importer->import('reports.xml', $locator);
        $importer->import('sales.xml', $locator);
    }
}
