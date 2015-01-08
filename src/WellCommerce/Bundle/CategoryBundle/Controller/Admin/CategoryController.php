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
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CategoryController extends AbstractAdminController
{
    public function indexAction(Request $request)
    {
        $categories = $this->manager->getRepository()->findAll();

        if (count($categories)) {
            $category = current($categories);

            return $this->manager->getRedirectHelper()->redirectToAction('edit', [
                'id' => $category->getId()
            ]);
        }

        $tree = $this->buildTreeForm();

        return [
            'tree' => $tree
        ];
    }

    public function addAction(Request $request)
    {
        $category = $this->getRepository()->quickAddCategory($request->request);

        return $this->jsonResponse([
            'id' => $category->getId()
        ]);
    }

    public function editAction(Request $request)
    {
        $tree     = $this->buildTreeForm();
        $resource = $this->findOr404($request);
        $form     = $this->getForm($resource);

        if ($form->handleRequest()->isValid()) {
            $this->manager->updateResource($resource, $request);
            if ($form->isAction('continue')) {
                return $this->manager->getRedirectHelper()->redirectToAction('edit', [
                    'id' => $resource->getId()
                ]);
            }

            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        return [
            'tree' => $tree,
            'form' => $form
        ];
    }

    public function sortAction(Request $request)
    {
        $items = $request->request->get('items');
        $this->getRepository()->changeOrder($items);

        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Builds nested tree form
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface
     */
    private function buildTreeForm()
    {
        return $this->get('category_tree.form_builder')->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select'
        ]);
    }

    /**
     * @return \WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->manager->getRepository();
    }
}
