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

namespace WellCommerce\Bundle\CategoryBundle\Context\Front;

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;

/**
 * Interface CategoryContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryContextInterface
{
    /**
     * @param CategoryInterface $category
     */
    public function setCurrentCategory(CategoryInterface $category);

    /**
     * @return CategoryInterface
     */
    public function getCurrentCategory() : CategoryInterface;

    /**
     * @return int
     */
    public function getCurrentCategoryIdentifier() : int;

    /**
     * @return bool
     */
    public function hasCurrentCategory() : bool;
}
