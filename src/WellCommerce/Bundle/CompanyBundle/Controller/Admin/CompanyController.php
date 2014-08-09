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

namespace WellCommerce\Bundle\CompanyBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Bundle\CompanyBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class CompanyController extends AbstractAdminController
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $repository;

    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('company.datagrid'))
        ];
    }

    public function addAction(Request $request)
    {
//        $form = $this->getCompanyForm();

        if ($form->isValid()) {

            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            $entity = new Company();

            $propertyAccessor->setValue($entity, 'shortName', 111);
            print_r($entity);
            print_r($form->getSubmitValuesFlat());
            die();
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('New company added successfully.');

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
     * @ParamConverter("company", class="WellCommerceCompanyBundle:Company")
     */
    public function editAction(Company $company)
    {

    }

    /**
     * Returns company form
     *
     * @param Company $company
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getCompanyForm(Company $company)
    {
        return $this->getFormBuilder($this->get('company.form'), $company, [
            'name' => 'company'
        ]);
    }

    /**
     * Sets repository object
     *
     * @param CompanyRepositoryInterface $repository
     */
    public function setRepository(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
