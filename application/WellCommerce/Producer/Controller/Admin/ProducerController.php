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
namespace WellCommerce\Producer\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Producer\Repository\ProducerRepositoryInterface;

/**
 * Class ProducerController
 *
 * @package WellCommerce\Producer\Controller\Admin
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
            'name' => 'producer'
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

        $form = $this->createForm($this->get('producer.form'), $model, [
            'name' => 'producer'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.producer.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'producer' => $model,
            'form'     => $form
        ];
    }

    /**
     * Sets producer repository object
     *
     * @param ProducerRepositoryInterface $repository
     */
    public function setRepository(ProducerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
