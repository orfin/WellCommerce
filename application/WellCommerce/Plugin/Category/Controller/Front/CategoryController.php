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
namespace WellCommerce\Plugin\Category\Controller\Front;

use WellCommerce\Core\Component\Controller\AbstractFrontController;
use WellCommerce\Plugin\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryController
 *
 * @package WellCommerce\Plugin\Category\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractFrontController
{
    private $repository;

    public function indexAction($slug)
    {
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
