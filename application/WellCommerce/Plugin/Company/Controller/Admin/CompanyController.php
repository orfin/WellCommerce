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
namespace WellCommerce\Plugin\Company\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Plugin\Company\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('company.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('company.form'), null, [
            'name'   => 'add_company',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.company.add')
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData());

            return $this->redirect($this->generateUrl('admin.company.index'));
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

        $form = $this->createForm($this->get('company.form'), $model, [
            'name'   => 'edit_company',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.company.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->generateUrl('admin.company.index'));
        }

        return [
            'company' => $model,
            'form'    => $form
        ];
    }
}
