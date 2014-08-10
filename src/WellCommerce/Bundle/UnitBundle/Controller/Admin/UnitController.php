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

namespace WellCommerce\Bundle\UnitBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use WellCommerce\Bundle\UnitBundle\Repository\UnitRepositoryInterface;
use WellCommerce\Bundle\UnitBundle\Entity\Unit;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class UnitController
 *
 * @package WellCommerce\Bundle\UnitBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class UnitController extends AbstractAdminController
{
    /**
     * @var UnitRepositoryInterface
     */
    private $repository;

    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('unit.datagrid'))
        ];
    }

    public function addAction()
    {
        $locale = new Unit();
        $form    = $this->getUnitForm($locale);

        if ($form->isSubmitted()) {
            $form->handleRequest();
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($locale);
                $em->flush();

                $this->addSuccessMessage('unit.success');

                return $this->redirect($this->getDefaultUrl());
            }

            $this->addErrorMessage($form->getErrors());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * @ParamConverter("locale", class="WellCommerceUnitBundle:Unit")
     */
    public function editAction(Unit $locale)
    {
        $form = $this->getUnitForm($locale);

        if ($form->isSubmitted()) {
            $form->handleRequest();
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($locale);
                $em->flush();

                $this->addSuccessMessage('unit.success');

                return $this->redirect($this->getDefaultUrl());
            }

            $this->addErrorMessage($form->getErrors());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Returns unit form
     *
     * @param Unit $unit
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getUnitForm(Unit $unit)
    {
        return $this->getFormBuilder($this->get('unit.form'), $unit, [
            'name' => 'unit'
        ]);
    }

    /**
     * Sets repository object
     *
     * @param UnitRepositoryInterface $repository
     */
    public function setRepository(UnitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
