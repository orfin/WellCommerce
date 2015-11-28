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

namespace WellCommerce\AppBundle\Service\AdminMenu\Importer;

use Symfony\Component\Config\FileLocatorInterface;

/**
 * Interface AdminMenuImporterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminMenuImporterInterface
{
    /**
     * Imports admin menu structure from file
     *
     * @param string               $file
     * @param FileLocatorInterface $locator
     */
    public function import($file, FileLocatorInterface $locator);
}
