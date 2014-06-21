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

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\ClientGroup\Repository\ClientGroupRepositoryInterface;

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
            'name' => 'client_group',
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('Changes saved successfully.');

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

        $form = $this->createForm($this->get('client_group.form'), $model, [
            'name' => 'client_group',
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'client_group' => $model,
            'form'         => $form
        ];
    }

    /**
     * Sets client group repository object
     *
     * @param ClientGroupRepositoryInterface $repository
     */
    public function setRepository(ClientGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
