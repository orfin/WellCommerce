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
namespace WellCommerce\Plugin\ShippingMethod\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Plugin\ShippingMethod\Repository\ShippingMethodRepositoryInterface;

/**
 * Class ShippingMethodController
 *
 * @package WellCommerce\Plugin\ShippingMethod\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        echo 1;
        print_r($this->get('shipping_method.calculator.collection')->all());
        die();
        return [
            'datagrid' => $this->createDataGrid($this->get('shipping_method.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('shipping_method.form'), null, [
            'name' => 'shipping_method'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('New shipping method added successfully.');

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

        $form = $this->createForm($this->get('shipping_method.form'), $model, [
            'name' => 'shipping_method'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Shipping method saved successfully.');

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.shipping_method.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'shipping_method' => $model,
            'form'            => $form
        ];
    }

    /**
     * Sets shipping_method repository object
     *
     * @param ShippingMethodRepositoryInterface $repository
     */
    public function setRepository(ShippingMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
