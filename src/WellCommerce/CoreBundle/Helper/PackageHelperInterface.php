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

namespace WellCommerce\CoreBundle\Helper;

/**
 * Class PackageHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PackageHelperInterface
{

    const DEFAULT_BRANCH_VERSION      = 'dev-master';
    const DEFAULT_PACKAGE_PLUGIN_TYPE = 'wellcommerce-plugin';
    const DEFAULT_PACKAGE_THEME_TYPE  = 'wellcommerce-theme';
    const ACTION_REQUIRE              = 'require';
    const ACTION_UPDATE               = 'update';
    const ACTION_REMOVE               = 'remove';

    /**
     * Returns all packages
     *
     * @param array $criteria
     *
     * @return array
     */
    public function getPackages(array $criteria);

    /**
     * Returns information about package
     *
     * @param string $name
     *
     * @return \Packagist\Api\Result\Package
     */
    public function getPackage($name);
}
