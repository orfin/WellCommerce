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
namespace WellCommerce\Company\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Company\Form\CompanyDataTransformer;
use WellCommerce\Company\Repository\CompanyRepositoryInterface;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Company\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyController extends AbstractAdminController
{
    private $repository;

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
            'name' => 'company'
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

        $form = $this->createForm($this->get('company.form'), $model, [
            'name' => 'company'
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
            'company' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets company repository object
     *
     * @param CompanyRepositoryInterface $repository
     */
    public function setRepository(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
