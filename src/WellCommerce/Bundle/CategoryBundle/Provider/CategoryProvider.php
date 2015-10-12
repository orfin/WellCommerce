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
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;

/**
 * Class CategoryProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProvider extends AbstractProvider implements CategoryProviderInterface
{
    /**
     * @var CategoryInterface
     */
    protected $category;
    
    /**
     * {@inheritdoc}
     */
    public function setCurrentCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCurrentCategory()
    {
        return $this->category;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasCurrentCategory()
    {
        return (null !== $this->category);
    }
}
