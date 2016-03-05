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

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

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
        $categories = $this->manager->getRepository()->matching(new Criteria());
        $tree       = $this->buildTreeForm();

        if ($categories->count()) {
            $category = $categories->first();

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
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

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
            if ($form->isValid()) {
                $this->manager->updateResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('edit', [
            'tree'     => $this->buildTreeForm(),
            'form'     => $form,
            'resource' => $resource
        ]);
    }

    /**
     * Builds nested tree form
     *
     * @return \WellCommerce\Component\Form\Elements\FormInterface
     */
    protected function buildTreeForm()
    {
        return $this->get('category_tree.form_builder.admin')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }
}
