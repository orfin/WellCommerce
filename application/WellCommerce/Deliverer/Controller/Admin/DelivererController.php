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
namespace WellCommerce\Deliverer\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Controller\Admin\AbstractAdminController;
use WellCommerce\Deliverer\Repository\DelivererRepositoryInterface;

/**
 * Class DelivererController
 *
 * @package WellCommerce\Deliverer\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('deliverer.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('deliverer.form'), null, [
            'name' => 'deliverer'
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

        $form = $this->createForm($this->get('deliverer.form'), $model, [
            'name' => 'deliverer'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.deliverer.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'deliverer' => $model,
            'form'      => $form
        ];
    }

    /**
     * Sets deliverer repository object
     *
     * @param DelivererRepositoryInterface $repository
     */
    public function setRepository(DelivererRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
