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
 * @Route("/company")
 */
class CompanyController extends AbstractAdminController
{
    private $em;

    /**
     * @InjectParams({
     *     "em" = @Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        print_r($this->datagrid);
        $entities = $this->em->getRepository('WellCommerceCompanyBundle:Company')->findAll();

        return [

        ];
    }

    /**
     * @Route("/add")
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
     * @Route("/edit/{id}")
     * @Template()
     * @ParamConverter("company", class="WellCommerceCompanyBundle:Company")
     */
    public function editAction(Company $company)
    {
    }
}
