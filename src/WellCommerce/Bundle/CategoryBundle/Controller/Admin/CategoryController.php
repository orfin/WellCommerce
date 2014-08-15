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

namespace WellCommerce\Bundle\CategoryBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepository;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class CategoryController
 *
 * @package WellCommerce\Bundle\CategoryBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class CategoryController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface
     */
    protected $repository;

    public function indexAction()
    {
        $tree = $this->getFormBuilder($this->get('category.tree'), null, [
            'name'  => 'category_tree',
            'class' => 'category-select'
        ]);

        return [
            'tree' => $tree
        ];
    }

    public function addAction(Request $request)
    {
        $category = $this->repository->quickAddCategory($request);

        return new JsonResponse(['id' => $category->getId()]);
    }

    public function editAction()
    {
        $tree = $this->getFormBuilder($this->get('category.tree'), null, [
            'name'  => 'category_tree',
            'class' => 'category-select'
        ]);

        return [
            'tree' => $tree
        ];
    }
}
