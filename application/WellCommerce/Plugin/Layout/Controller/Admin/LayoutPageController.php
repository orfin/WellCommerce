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

use WellCommerce\Core\Controller\AbstractAdminController;

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
        $populateData = $this->getRepository()->getPopulateData($id);
        $form         = $this->getForm()->init($populateData);
        $tree         = $this->getTree()->init();

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->getRepository()->save($form->getSubmitValuesFlat(), $id);

            return $this->redirect($this->generateUrl($this->getDefaultRoute()));
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

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('layout_page.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('layout_page.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.layout_page.index';
    }
}
