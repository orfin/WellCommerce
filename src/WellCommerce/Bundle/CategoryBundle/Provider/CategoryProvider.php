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
     * @var null
     */
    protected $tree = null;

    /**
     * Constructor
     *
     * @param CategoryDataSet $dataset
     */
    public function __construct(CategoryDataSet $dataset)
    {
        $this->dataset = $dataset;
    }

    public function getCategoriesTree(
        $limit = CategoryProviderInterface::CATEGORY_TREE_LIMIT,
        $orderBy = CategoryProviderInterface::CATEGORY_ORDER_BY,
        $orderDir = CategoryProviderInterface::CATEGORY_ORDER_DIR
    ) {
        if (null === $this->tree) {
            $results = $this->dataset->getResults(new DataSetRequest([
                'limit'    => $limit,
                'orderBy'  => $orderBy,
                'orderDir' => $orderDir,
            ]));

            $treeBuilder = new CategoryTreeBuilder($results['rows']);
            $this->tree  = $treeBuilder->getTree();
        }

        return $this->tree;
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