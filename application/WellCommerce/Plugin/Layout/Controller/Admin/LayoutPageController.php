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
namespace WellCommerce\Plugin\Layout\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;

/**
 * Class LayoutPageController
 *
 * @package WellCommerce\Plugin\LayoutPage\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageController extends AbstractAdminController
{
    public function indexAction()
    {
        $tree = $this->getTree()->init();

        return Array(
            'tree' => $tree
        );
    }

    public function editAction($id)
    {
        $populateData = $this->repository->getPopulateData($id);
        $form         = $this->formBuilder->init($populateData);
        $tree         = $this->getTree()->init();

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->repository->save($form->getSubmitValuesGrouped(), $id);

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form,
            'tree' => $tree,
        ];
    }

    /**
     * Get Tree
     */
    protected function getTree()
    {
        return $this->get('layout_page.tree');
    }
}
