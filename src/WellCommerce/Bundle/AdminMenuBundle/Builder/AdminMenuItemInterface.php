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

namespace WellCommerce\Bundle\AdminMenuBundle\Builder;

/**
 * Interface AdminMenuItemInterface
 *
 * @package WellCommerce\Bundle\AdminMenuBundle\Builder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminMenuItemInterface
{
    /**
     * Returns menu item identifier
     *
     * @return mixed
     */
    public function getId();

    /**
     * Returns menu item name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Returns menu item children
     *
     * @return mixed
     */
    public function getChildren();

    /**
     * Returns menu item CSS class
     *
     * @return mixed
     */
    public function getClass();

    /**
     * Returns menu item link
     *
     * @return mixed
     */
    public function getLink();

    /**
     * Returns menu item sort order
     *
     * @return mixed
     */
    public function getSortOrder();

    /**
     * Returns menu item property path
     *
     * @return mixed
     */
    public function getPath();

    /**
     * Sort element children by sort_order property
     *
     * @return mixed
     */
    public function sortChildren();

} 