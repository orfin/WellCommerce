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
namespace WellCommerce\Core\Controller;

use WellCommerce\Core\Controller;

/**
 * Class AdminController
 *
 * @package WellCommerce\Core\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AdminController extends Controller
{

    /**
     * Default indexAction logic for all controllers
     *
     * @return array
     */
    public function indexAction()
    {
        $datagrid = $this->getDataGrid();

        $datagrid->configure();

        $datagrid->init();

        return [
            'datagrid' => $datagrid,
        ];
    }

    /**
     * Default addAction logic for all controllers
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction()
    {
        $form = $this->getForm()->init();

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->getRepository()->save($form->getSubmitValuesFlat());

            return $this->redirect($this->generateUrl($this->getDefaultRoute()));
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Default editAction logic for all controllers
     *
     * @param $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id)
    {
        $populateData = $this->getRepository()->getPopulateData($id);
        $form         = $this->getForm()->init($populateData);

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->getRepository()->save($form->getSubmitValuesFlat(), $id);

            return $this->redirect($this->generateUrl($this->getDefaultRoute()));
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Returns repository service for controller
     *
     * @return \WellCommerce\Core\Repository|object
     */
    abstract protected function getRepository();

    /**
     * Returns Form service for controller
     *
     * @return \WellCommerce\Core\Form|object
     */
    abstract protected function getForm();
}