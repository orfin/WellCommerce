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

namespace WellCommerce\Bundle\CategoryBundle\Storage;

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;

/**
 * Interface CategoryContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryStorageInterface
{
    public function setCurrentCategory(CategoryInterface $category);

    public function getCurrentCategory() : CategoryInterface;

    public function getCurrentCategoryIdentifier() : int;

    public function hasCurrentCategory() : bool;
}
