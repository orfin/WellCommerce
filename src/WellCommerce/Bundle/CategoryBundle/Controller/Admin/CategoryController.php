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
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Component\Form\Elements\FormInterface;

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

    public function indexAction() : Response
    {
        $categories = $this->manager->getRepository()->matching(new Criteria());
        $tree       = $this->createCategoryTreeForm();

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

    public function addAction(Request $request) : Response
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

    public function editAction(Request $request) : Response
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
            'tree'     => $this->createCategoryTreeForm(),
            'form'     => $form,
            'resource' => $resource
        ]);
    }

    protected function createCategoryTreeForm() : FormInterface
    {
        return $this->get('category_tree.form_builder.admin')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }
}
