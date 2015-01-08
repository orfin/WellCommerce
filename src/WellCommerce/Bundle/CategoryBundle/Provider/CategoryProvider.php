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

use WellCommerce\Bundle\CategoryBundle\DataSet\Front\CategoryDataSet;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CategoryBundle\Tree\CategoryTreeBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;

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
     * @var CategoryDataSet
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param CategoryDataSet $dataset
     */
    public function __construct(CategoryDataSet $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoriesTree(array $parameters = [])
    {
        $rows        = $this->getDataSetRows($parameters);
        $treeBuilder = new CategoryTreeBuilder($rows);

        return $treeBuilder->getTree();
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

    /**
     * Makes dataset request and return its rows
     *
     * @param array $parameters
     *
     * @return array
     */
    private function getDataSetRows($parameters)
    {
        $request = new DataSetRequest($parameters);
        $results = $this->dataset->getResults($request);

        return $results['rows'];
    }

}