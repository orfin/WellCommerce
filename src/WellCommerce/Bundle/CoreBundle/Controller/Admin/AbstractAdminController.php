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
namespace WellCommerce\Bundle\CoreBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractAdminController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    protected $manager;
    protected $dataGrid;
    protected $formBuilder;
    
    public function __construct(ManagerInterface $manager, FormBuilderInterface $formBuilder = null, DataGridInterface $dataGrid = null)
    {
        $this->manager     = $manager;
        $this->dataGrid    = $dataGrid;
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
        $resource = $this->manager->initResource();
        $form     = $this->manager->getForm($resource);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->createResource($resource);
            }
            
            return $this->createFormDefaultJsonResponse($form);
        }
        
        return $this->displayTemplate('add', [
            'form' => $form
        ]);
    }
    
    public function editAction(Request $request) : Response
    {
        $resource = $this->manager->findResource($request);
        if (null === $resource) {
            return $this->redirectToAction('index');
        }
        
        $form = $this->manager->getForm($resource);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($resource);
            }
            
            return $this->createFormDefaultJsonResponse($form);
        }
        
        return $this->displayTemplate('edit', [
            'form'     => $form,
            'resource' => $resource
        ]);
    }
    
    public function deleteAction(int $id) : Response
    {
        $this->getDoctrineHelper()->disableFilter('locale');
        
        try {
            $resource = $this->manager->getRepository()->find($id);
            $this->manager->removeResource($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()]);
        }
        
        return $this->jsonResponse(['success' => true]);
    }
    
    protected function createFormDefaultJsonResponse(FormInterface $form) : JsonResponse
    {
        return $this->jsonResponse([
            'valid'      => $form->isValid(),
            'continue'   => $form->isAction('continue'),
            'next'       => $form->isAction('next'),
            'redirectTo' => $this->getRedirectToActionUrl('index'),
            'error'      => $form->getError(),
        ]);
    }
}
