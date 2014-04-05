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
        $this->datagrid->configure();

        $this->datagrid->init();

        return [
            'datagrid' => $this->datagrid,
        ];
    }

    /**
     * Default addAction logic for all controllers
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction()
    {
        $form = $this->formBuilder->init();

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->repository->save($form->getSubmitValuesFlat());

            return $this->redirect($this->getDefaultUrl());
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
        $populateData = $this->repository->getPopulateData($id);
        $form         = $this->formBuilder->init($populateData);

        if ($this->getRequest()->isMethod('POST') && $form->isValid()) {

            $this->repository->save($form->getSubmitValuesFlat(), $id);

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Evaluates default route for current controller. All admin controllers must have indexAction
     *
     * @return string
     */
    protected function getDefaultUrl()
    {
        list($mode, $controller) = explode('.', $this->getRequest()->attributes->get('_route'), 3);

        $url = sprintf('%s.%s.%s', $mode, $controller, 'index');

        return $this->generateUrl($url);
    }
}