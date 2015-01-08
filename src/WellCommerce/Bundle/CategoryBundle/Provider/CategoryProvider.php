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
     * Returns categories tree
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getCategoriesTree(
        $limit = CategoryProviderInterface::CATEGORY_TREE_LIMIT,
        $orderBy = CategoryProviderInterface::CATEGORY_ORDER_BY,
        $orderDir = CategoryProviderInterface::CATEGORY_ORDER_DIR
    ) {
        return $this->getTree([
            'limit'    => $limit,
            'orderBy'  => $orderBy,
            'orderDir' => $orderDir,
        ]);
    }

    /**
     * Returns built tree structure
     *
     * @param array $parameters
     *
     * @return array
     */
    private function getTree($parameters)
    {
        $rows        = $this->getDataSetRows($parameters);
        $treeBuilder = new CategoryTreeBuilder($rows);

        return $treeBuilder->getTree();
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
        $results = $this->dataset->getResults(new DataSetRequest($request));

        return $results['rows'];
    }

    public function setCurrentResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return Category
     */
    public function getCurrentResource()
    {
        return $this->resource;
    }

}