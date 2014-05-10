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
namespace WellCommerce\Plugin\User\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\User\DataGrid\Config;

/**
 * Class UserController
 *
 * @package WellCommerce\Plugin\User\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('user.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('user.form'), null, [
            'name'   => 'add_user',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.user.add')
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

        $form = $this->createForm($this->get('user.form'), $model, [
            'name'   => 'edit_user',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.user.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'user' => $model,
            'form' => $form
        ];
    }

    /**
     * User login action
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction()
    {
        $form = $this->createForm($this->get('user.form_login'), null, [
            'name'   => 'login_user',
            'action' => $this->generateUrl('admin.user.login'),
            'class'  => 'login-form'
        ]);

        if ($form->isValid()) {
            $this->repository->authProcess($form->getSubmittedData());

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Logout the user from administration area
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        $this->getSession()->remove('admin');
        return $this->redirect($this->generateUrl('admin.user.login'));
    }
}
