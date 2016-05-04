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
 * Class CategoryStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CategoryStorage implements CategoryStorageInterface
{
    private $currentCategory;

    public function setCurrentCategory(CategoryInterface $category)
    {
        $this->currentCategory = $category;
    }

    public function getCurrentCategory() : CategoryInterface
    {
        return $this->currentCategory;
    }

    public function getCurrentCategoryIdentifier() : int
    {
        if ($this->hasCurrentCategory()) {
            return $this->getCurrentCategory()->getId();
        }

        return 0;
    }

    public function hasCurrentCategory() : bool
    {
        return $this->currentCategory instanceof CategoryInterface;
    }
}
