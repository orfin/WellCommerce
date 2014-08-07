<?php

namespace WellCommerce\Bundle\CompanyBundle\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
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
     * @Template()
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('company.datagrid'))
        ];
    }

    /**
     * @Template()
     */
    public function addAction()
    {
        $entity = new Company();
        $entity->setName(11111);
        $this->em->persist($entity);
        $this->em->flush();

        return [];
    }

    /**
     * @Template()
     * @ParamConverter("company", class="WellCommerceCompanyBundle:Company")
     */
    public function editAction(Company $company)
    {
    }
}
