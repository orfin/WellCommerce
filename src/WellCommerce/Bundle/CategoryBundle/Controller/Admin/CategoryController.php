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
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CategoryBundle\Manager\CategoryManager;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractAdminController
{
    public function indexAction() : Response
    {
        $categories = $this->getManager()->getRepository()->matching(new Criteria());
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
        $category       = $this->getManager()->quickAddCategory($categoriesName, $parentCategory);

        return $this->jsonResponse([
            'id' => $category->getId(),
        ]);
    }

    public function editAction(int $id) : Response
    {
        $category = $this->getManager()->getRepository()->find($id);
        $form     = $this->getForm($category);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($category);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('edit', [
            'tree'     => $this->createCategoryTreeForm(),
            'form'     => $form,
            'resource' => $category
        ]);
    }

    protected function createCategoryTreeForm() : FormInterface
    {
        return $this->get('category_tree.form_builder.admin')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }

    protected function getManager() : CategoryManager
    {
        return parent::getManager();
    }
}
