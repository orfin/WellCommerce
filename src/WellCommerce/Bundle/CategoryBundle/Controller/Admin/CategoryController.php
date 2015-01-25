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
    public function indexAction()
    {
        $categories = $this->getManager()->getRepository()->findAll();

        if (count($categories)) {
            $category = current($categories);

            return $this->redirectToAction('edit', [
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
            'id' => $category->getId(),
        ]);
    }

    public function editAction(Request $request)
    {
        $manager  = $this->getManager();
        $tree     = $this->buildTreeForm();
        $resource = $manager->findResource($request);
        $form     = $manager->getForm($resource);

        if ($form->handleRequest()->isValid()) {
            $manager->updateResource($resource, $request);
            if ($form->isAction('continue')) {
                return $this->redirectToAction('edit', [
                    'id' => $resource->getId()
                ]);
            }

            return $this->redirectToAction('index');
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
     * @return \WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository();
    }
}
