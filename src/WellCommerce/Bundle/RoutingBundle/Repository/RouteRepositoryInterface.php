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

namespace WellCommerce\Bundle\RoutingBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;

/**
 * Interface RouteRepositoryInterface
 *
 * @package WellCommerce\Bundle\RoutingBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteRepositoryInterface extends RepositoryInterface, DataGridAwareRepositoryInterface
{
    /**
     * Generates and validates uniqueness of slug
     *
     * @param string   $name   Passed value to generate slug
     * @param int|null $id     Entity id
     * @param string   $locale Field locale
     * @param array    $values Other sluggable field values
     *
     * @return string
     */
    public function generateSlug($name, $id, $locale, $values, $iteration = 0);
}