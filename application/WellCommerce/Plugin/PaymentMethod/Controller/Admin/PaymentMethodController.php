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
namespace WellCommerce\Plugin\PaymentMethod\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Plugin\PaymentMethod\Repository\PaymentMethodRepositoryInterface;

/**
 * Class PaymentMethodController
 *
 * @package WellCommerce\Plugin\PaymentMethod\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('payment_method.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('payment_method.form'), null, [
            'name' => 'payment_method'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('New payment method added successfully.');

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

        $form = $this->createForm($this->get('payment_method.form'), $model, [
            'name' => 'payment_method'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Payment method saved successfully.');

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.payment_method.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'payment_method' => $model,
            'form'           => $form
        ];
    }

    /**
     * Sets payment_method repository object
     *
     * @param PaymentMethodRepositoryInterface $repository
     */
    public function setRepository(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
