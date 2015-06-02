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

namespace WellCommerce\Bundle\CategoryBundle\Provider;

use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Class CategoryProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryProviderInterface extends ProviderInterface
{
    /**
     * Sets currently viewed category
     *
     * @param Category $category
     */
    public function setCurrentCategory(Category $category);

    /**
     * Returns an instance of currently viewed category
     *
     * @return Category
     */
    public function getCurrentCategory();

    /**
     * Checks whether provider contains category object
     *
     * @return bool
     */
    public function hasCurrentCategory();
}
