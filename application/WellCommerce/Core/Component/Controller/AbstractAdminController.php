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
namespace WellCommerce\Core\Component\Controller;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
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
}