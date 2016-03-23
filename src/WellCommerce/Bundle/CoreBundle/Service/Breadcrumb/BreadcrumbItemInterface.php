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

namespace WellCommerce\Bundle\CoreBundle\Service\Breadcrumb;

/**
 * Interface BreadcrumbItemInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface BreadcrumbItemInterface
{
    /**
     * Returns menu item name
     *
     * @return mixed
     */
    public function getName();

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
}
