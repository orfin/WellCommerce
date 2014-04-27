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
    public function indexAction()
    {
        $grid = $this->get('client_group.datagrid');

        $datagrid = $this->createDataGrid($grid, [
            'id'             => 'client_group',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadClientGroup', $grid, 'loadData']),
                'edit_row'   => 'editClientGroup',
                'click_row'  => 'editClientGroup',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteClientGroup', $grid, 'deleteRow']),
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.client_group.edit')
            ]
        ]);

        return [
            'datagrid' => $datagrid
        ];
    }

    public function addAction()
    {
        $form = $this->createForm($this->get('client_group.form'), null, [
            'name'   => 'client_group',
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

    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('client_group.form'), $model, [
            'name'   => 'client_group',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.client_group.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->generateUrl('admin.client_group.index'));
        }

        return [
            'model' => $model,
            'form'  => $form
        ];
    }
}
