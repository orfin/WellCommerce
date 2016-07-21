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

namespace WellCommerce\Bundle\AvailabilityBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AvailabilityBundle\DataGrid\AvailabilityDataGrid;
use WellCommerce\Bundle\AvailabilityBundle\Entity\Availability;
use WellCommerce\Bundle\AvailabilityBundle\Form\Admin\AvailabilityFormBuilder;
use WellCommerce\Bundle\AvailabilityBundle\Manager\AvailabilityManager;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use Zend\Stdlib\Response;

/**
 * Class AvailabilityController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityController extends AbstractAdminController
{
    public function __construct(AvailabilityManager $manager, AvailabilityFormBuilder $formBuilder, AvailabilityDataGrid $dataGrid)
    {
        $this->manager     = $manager;
        $this->formBuilder = $formBuilder;
    }
    
    public function indexAction() : Response
    {
        return $this->displayTemplate('index', [
            'datagrid' => $this->dataGrid->getInstance()
        ]);
    }
    
    public function gridAction(Request $request) : Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->getRouterHelper()->redirectToAction('index');
        }
        
        try {
            $results = $this->dataGrid->loadResults($request);
        } catch (\Exception $e) {
            $results = nl2br($e->getMessage());
        }
        
        return $this->jsonResponse($results);
    }
    
    public function addAction(Request $request) : Response
    {
        $resource = $this->getManager()->initResource();
        $form     = $this->getForm($resource);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->createResource($resource);
            }
            
            return $this->createFormDefaultJsonResponse($form);
        }
        
        return $this->displayTemplate('add', [
            'form' => $form
        ]);
    }
    
    public function editAction(Availability $availability) : Response
    {
        $form = $this->getForm($availability);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->save($availability);
            }
            
            return $this->createFormDefaultJsonResponse($form);
        }
        
        return $this->displayTemplate('edit', [
            'form'         => $form,
            'availability' => $availability
        ]);
    }
    
    public function deleteAction(Availability $availability) : Response
    {
        $this->getDoctrineHelper()->disableFilter('locale');
        try {
            $resource = $this->getManager()->getRepository()->findOneBy(['id' => $id]);
            $this->getManager()->removeResource($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getTraceAsString()]);
        }
        
        return $this->jsonResponse(['success' => true]);
    }
    
}
