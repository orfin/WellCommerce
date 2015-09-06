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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\CategoryBundle\Manager\Admin\CategoryManager
     */
    protected $manager;

    /**
     * List categories action
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $categories = $this->manager->getRepository()->findAll();
        $tree       = $this->buildTreeForm();

        if (count($categories)) {
            $category = current($categories);

            return $this->redirectToAction('edit', [
                'id' => $category->getId()
            ]);
        }

        return $this->displayTemplate('index', [
            'tree' => $tree
        ]);
    }

    /**
     * Add category action
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request)
    {
        $categoriesName = (string)$request->request->get('name');
        $parentCategory = (int)$request->request->get('parent');
        $category       = $this->manager->quickAddCategory($categoriesName, $parentCategory);

        return $this->jsonResponse([
            'id' => $category->getId(),
        ]);
    }

    /**
     * Edit category action
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $resource = $this->manager->findResource($request);
        $form     = $this->manager->getForm($resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($valid = $form->isValid()) {
                $this->manager->updateResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('edit', [
            'tree' => $this->buildTreeForm(),
            'form' => $form,
        ]);
    }

    /**
     * Builds nested tree form
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    private function buildTreeForm()
    {
        return $this->get('category_tree.form_builder')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }

    /**
     * Sort categories action
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sortAction(Request $request)
    {
        $this->manager->sortCategories($request->request->get('items'));

        return $this->jsonResponse(['success' => true]);
    }
}
