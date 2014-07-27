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

namespace WellCommerce\Category\Provider;

use WellCommerce\Category\Model\Category;

/**
 * Interface CategoryProviderInterface
 *
 * @package WellCommerce\Category\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryProviderInterface
{
    /**
     * Sets current category data
     *
     * @param Category $category Category model
     */
    public function setCurrent(Category $category);

    /**
     * Returns current category data
     *
     * @return mixed
     */
    public function getCurrent();
} 