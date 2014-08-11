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
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

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
        $company = new Company();
        $form    = $this->getCompanyForm($company);

        if ($form->handleRequest($request)->isValid()) {
            try {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();
                $this->addSuccessMessage('company.added.success');

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
    public function editAction(Request $request, Company $company)
    {
        $form = $this->getCompanyForm($company);

        if ($form->handleRequest($request)->isValid()) {
            try {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();
                $this->addSuccessMessage('company.saved.success');

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
