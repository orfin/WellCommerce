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

namespace WellCommerce\Plugin\AdminMenu\Builder;

/**
 * Interface AdminMenuBuilderInterface
 *
 * @package WellCommerce\Plugin\AdminMenu\Builder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminMenuBuilderInterface
{
    /**
     * Returns admin menu as array
     *
     * @return array
     */
    public function getMenu();

    /**
     * Sorting function for admin menu items
     *
     * @param $a
     * @param $b
     *
     * @return mixed
     */
    public function sortMenu($a, $b);

    /**
     * @param AdminMenuItemInterface $item
     *
     * @return mixed
     */
    public function add(AdminMenuItemInterface $item);
}