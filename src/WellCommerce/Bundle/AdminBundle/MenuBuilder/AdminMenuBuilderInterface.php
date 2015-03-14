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

namespace WellCommerce\Bundle\AdminBundle\MenuBuilder;

/**
 * Interface AdminMenuBuilderInterface
 *
 * @package WellCommerce\Bundle\AdminBundle\MenuBuilder
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
     * @param AdminMenuItemInterface $a
     * @param AdminMenuItemInterface $b
     *
     * @return integer
     */
    public function sortMenu(AdminMenuItemInterface $a, AdminMenuItemInterface $b);

    /**
     * Adds new element to menu
     *
     * @param AdminMenuItemInterface $item
     *
     * @return mixed
     */
    public function add(AdminMenuItemInterface $item);
}
