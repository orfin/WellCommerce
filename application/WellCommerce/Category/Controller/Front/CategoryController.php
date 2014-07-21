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
namespace WellCommerce\Category\Controller\Front;

use WellCommerce\Core\Controller\Front\AbstractFrontController;
use WellCommerce\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryController
 *
 * @package WellCommerce\Category\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractFrontController
{
    public function indexAction($slug)
    {
        $category = $this->repository->findBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException($this->trans('The category does not exist'));
        }

        $this->get('category.provider')->setCurrent($category);

        $params = [

        ];

        $collection = $this->get('product.collection')->get();

        $datagrid = $this->createDataGrid($this->get('product.datagrid'));

        $where   = [];
        $where[] = [
            'column'   => 'category_id',
            'operator' => '=',
            'value'    => 32
        ];

        $result  = $datagrid->loadData([
            'limit'         => 100,
            'starting_from' => 0,
            'order_by'      => 'product_translation.name',
            'order_dir'     => 'ASC',
            'where'         => $where
        ]);
        print_r($result);
        die();

        return [
            'layout' => $this->renderLayout()
        ];
    }

    /**
     * Sets repository
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function setRepository(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
