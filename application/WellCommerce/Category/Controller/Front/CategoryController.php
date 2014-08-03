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
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    public function indexAction($slug)
    {
        $category = $this->repository->findBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException($this->trans('The category does not exist'));
        }

        $this->getCategoryProvider()->setCurrent($category);

        $dataset = $this->getDataSet($this->get('product.dataset'));

        $dataset->load([
            'starting_from' => 0,
            'limit'         => 100,
            'order_by'      => 'product_translation.name',
            'order_dir'     => 'asc'
        ]);
        $dataset->getRows();

        return [
            'layout'  => $this->renderLayout(),
            'dataset' => $dataset,
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
