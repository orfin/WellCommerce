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
namespace WellCommerce\Plugin\ClientGroup\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;

/**
 * Class ClientGroupController
 *
 * @package WellCommerce\Plugin\ClientGroup\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('client_group.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('client_group.form'), null, [
            'name'   => 'add_client_group',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.client_group.add')
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData());

            return $this->redirect($this->generateUrl('admin.client_group.index'));
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

        $form = $this->createForm($this->get('client_group.form'), $model, [
            'name'   => 'edit_client_group',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.client_group.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->generateUrl('admin.client_group.index'));
        }

        return [
            'client_group' => $model,
            'form'         => $form
        ];
    }
}
