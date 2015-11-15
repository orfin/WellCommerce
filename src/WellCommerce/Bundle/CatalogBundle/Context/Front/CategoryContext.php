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

namespace WellCommerce\Bundle\CatalogBundle\Context\Front;

use WellCommerce\Bundle\CatalogBundle\Entity\CategoryInterface;

/**
 * Class CategoryContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryContext implements CategoryContextInterface
{
    /**
     * @var CategoryInterface
     */
    protected $currentCategory;

    /**
     * {@inheritdoc}
     */
    public function setCurrentCategory(CategoryInterface $category)
    {
        $this->currentCategory = $category;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCategory()
    {
        return $this->currentCategory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCategoryIdentifier()
    {
        if ($this->hasCurrentCategory()) {
            return $this->currentCategory->getId();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentCategory()
    {
        return $this->currentCategory instanceof CategoryInterface;
    }
}
