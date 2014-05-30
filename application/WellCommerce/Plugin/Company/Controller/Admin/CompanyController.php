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
namespace WellCommerce\Plugin\Company\Controller\Admin;

use Symfony\Component\Validator\Validation;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Company\Form\CompanyDataTransformer;
use WellCommerce\Plugin\Company\Repository\CompanyRepositoryInterface;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Plugin\Company\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyController extends AbstractAdminController
{
    /**
     * @var CompanyRepositoryInterface
     */
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
            'name' => 'add_company'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat());

            return $this->redirect($this->generateUrl('admin.company.index'));
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
            'name' => 'edit_company'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat(), $id);

            return $this->redirect($this->generateUrl('admin.company.index'));
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
