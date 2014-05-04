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
namespace WellCommerce\Plugin\Producer\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Producer\DataGrid\Config;

/**
 * Class ProducerController
 *
 * @package WellCommerce\Plugin\Producer\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('producer.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('producer.form'), null, [
            'name'   => 'add_producer',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.producer.add')
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData());

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

        $form = $this->createForm($this->get('producer.form'), $model, [
            'name'   => 'edit_producer',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.producer.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'producer' => $model,
            'form'     => $form
        ];
    }
}
