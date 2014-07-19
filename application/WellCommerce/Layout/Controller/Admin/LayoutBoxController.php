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
namespace WellCommerce\Layout\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Layout\Repository\LayoutBoxRepositoryInterface;

/**
 * Class LayoutBoxController
 *
 * @package WellCommerce\Layout\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('layout_box.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('layout_box.form'), null, [
            'name' => 'layout_box'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesGrouped());
                $this->addSuccessMessage('Layout box added successfully.');

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

        $form = $this->createForm($this->get('layout_box.form'), $model, [
            'name' => 'layout_box'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesGrouped(), $id);
                $this->addSuccessMessage('Layout box saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'form'       => $form,
            'layout_box' => $model
        ];
    }

    /**
     * Sets layout_page repository object
     *
     * @param LayoutBoxRepositoryInterface $repository
     */
    public function setRepository(LayoutBoxRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
