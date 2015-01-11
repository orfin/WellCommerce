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
use WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder\CollectionBuilderFactoryInterface;

/**
 * Class CategoryProvider
 *
 * @package WellCommerce\Bundle\CategoryBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProvider implements CategoryProviderInterface
{
    /**
     * @var Category
     */
    protected $resource;

    /**
     * @var CollectionBuilderFactoryInterface
     */
    protected $collectionBuilderFactory;

    /**
     * Constructor
     *
     * @param CollectionBuilderFactoryInterface $collectionBuilderFactory
     */
    public function __construct(CollectionBuilderFactoryInterface $collectionBuilderFactory)
    {
        $this->collectionBuilderFactory = $collectionBuilderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoriesTree(array $parameters = [])
    {
        return $this->collectionBuilderFactory->getTree($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentResource($resource)
    {
        $this->setCurrentCategory($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentCategory(Category $category)
    {
        $this->resource = $category;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCategoryId()
    {
        return $this->resource->getId();
    }
}
