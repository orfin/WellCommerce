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
namespace WellCommerce\Profiler\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Controller\Admin\AbstractAdminController;
use WellCommerce\Profiler\Repository\ProfilerRepositoryInterface;

/**
 * Class ProfilerController
 *
 * @package WellCommerce\Profiler\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProfilerController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('product.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('product.form'), null, [
            'name' => 'product'
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

        $form = $this->createForm($this->get('product.form'), $model, [
            'name' => 'product'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage(sprintf('Profiler %s saved successfully.', $model->translation->first()->name));

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.product.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'product' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets product repository object
     *
     * @param ProfilerRepositoryInterface $repository
     */
    public function setRepository(ProfilerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
