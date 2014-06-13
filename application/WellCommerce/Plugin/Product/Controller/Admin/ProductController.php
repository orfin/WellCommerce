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
namespace WellCommerce\Plugin\Product\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Product\Repository\ProductRepositoryInterface;

/**
 * Class ProductController
 *
 * @package WellCommerce\Plugin\Product\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('product.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('product.form'), null, [
            'name' => 'add_product'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat());

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('product.form'), $model, [
            'name' => 'edit_product'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat(), $id);

            if ($form->isAction('continue')) {
                return $this->redirect($this->generateUrl('admin.product.edit', ['id' => $model->id]));
            }

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'product' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets product repository object
     *
     * @param ProductRepositoryInterface $repository
     */
    public function setRepository(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
