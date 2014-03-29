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

use WellCommerce\Core\Controller\AdminController;

/**
 * Class LayoutBoxController
 *
 * @package WellCommerce\Plugin\LayoutBox\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxController extends AdminController
{
    public function addAction()
    {
        $this->getLayoutManager()->getConfigurators();

        $form = $this->getForm()->init();

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->getRepository()->save($form->getSubmitValuesGrouped());

            return $this->redirect($this->generateUrl($this->getDefaultRoute()));
        }

        return [
            'form' => $form
        ];
    }

    public function editAction($id)
    {
        $populateData = $this->getRepository()->getPopulateData($id);
        $form         = $this->getForm()->init($populateData);

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->getRepository()->save($form->getSubmitValuesGrouped(), $id);

            return $this->redirect($this->generateUrl($this->getDefaultRoute()));
        }

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('layout_box.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('layout_box.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('layout_box.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.layout_box.index';
    }
}
