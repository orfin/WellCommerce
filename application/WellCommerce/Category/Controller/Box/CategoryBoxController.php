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

namespace WellCommerce\Category\Controller\Box;

use WellCommerce\Core\Controller\Box\AbstractBoxController;
use WellCommerce\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryBoxController
 *
 * @package WellCommerce\Category\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxController extends AbstractBoxController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    public function indexAction()
    {
        $categories = $this->repository->getCategoriesTree();

        return [
            'categories' => $categories
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
} 