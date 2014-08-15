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
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
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
        $name     = $request->request->get('name');
        $em       = $this->getEntityManager();
        $category = new Category();

        $category->setHierarchy(0);
        $category->translate()->setName($name);
        $category->mergeNewTranslations();
        $em->persist($category);
        $em->flush();

        return new JsonResponse(['id' => $category->getId()]);
    }

    public function editAction(Request $request)
    {
        $resource = $this->repository->findResource($request);

        $tree = $this->getFormBuilder($this->get('category.tree'), null, [
            'name'  => 'tree',
            'class' => 'category-select'
        ]);

        $form = $this->getFormBuilder($this->get('category.form'), $resource, [
            'name' => 'category',
        ]);

        return [
            'tree' => $tree,
            'form' => $form
        ];
    }

    public function sortAction(Request $request)
    {
        $items = $request->request->get('items');
        $this->repository->changeOrder($items);

        return new JsonResponse(['success' => true]);
    }
}
