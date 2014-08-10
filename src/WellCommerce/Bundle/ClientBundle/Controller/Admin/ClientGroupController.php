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

namespace WellCommerce\Bundle\ClientBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\ClientBundle\Repository\ClientGroupRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ClientGroupController
 *
 * @package WellCommerce\Bundle\ClientBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class ClientGroupController extends AbstractAdminController
{
    /**
     * @var ClientGroupRepositoryInterface
     */
    private $repository;

    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('client_group.datagrid'))
        ];
    }

    public function addAction()
    {
        $company = new ClientGroup();
        $form    = $this->getClientGroupForm($company);

        if ($form->isSubmitted()) {
            $form->handleRequest();
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();
                $this->addSuccessMessage('company.success');

                return $this->redirect($this->getDefaultUrl());
            }

            $this->addErrorMessage($form->getErrors());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * @ParamConverter("company", class="WellCommerceClientBundle:ClientGroup")
     */
    public function editAction(ClientGroup $company)
    {
        $form = $this->getClientGroupForm($company);

        if ($form->isSubmitted()) {
            $form->handleRequest();
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();

                $this->addSuccessMessage('company.success');

                return $this->redirect($this->getDefaultUrl());
            }

            $this->addErrorMessage($form->getErrors());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Returns company form
     *
     * @param ClientGroup $company
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getClientGroupForm(ClientGroup $clientGroup)
    {
        return $this->getFormBuilder($this->get('client_group.form'), $clientGroup, [
            'name'         => 'client_group'
        ]);
    }

    /**
     * Sets repository object
     *
     * @param ClientGroupRepositoryInterface $repository
     */
    public function setRepository(ClientGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
