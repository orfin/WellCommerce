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
namespace WellCommerce\Client\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Client\Repository\ClientRepositoryInterface;

/**
 * Class ClientController
 *
 * @package WellCommerce\Client\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('client.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('client.form'), null, [
            'name'   => 'client',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.client.add')
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('Client saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
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

        $form = $this->createForm($this->get('client.form'), $model, [
            'name'   => 'client',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.client.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Client saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'client' => $model,
            'form'   => $form
        ];
    }

    /**
     * Sets client repository
     *
     * @param ClientRepositoryInterface $repository
     */
    public function setRepository(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
