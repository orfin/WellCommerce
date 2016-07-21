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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\OrderBundle\Provider\Admin\OrderProviderInterface;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractAdminController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * @var null|DataGridInterface
     */
    protected $dataGrid;
    
    /**
     * AbstractAdminController constructor.
     *
     * @param ManagerInterface          $manager
     * @param FormBuilderInterface|null $formBuilder
     * @param DataGridInterface|null    $dataGrid
     */
    public function __construct(ManagerInterface $manager, FormBuilderInterface $formBuilder = null, DataGridInterface $dataGrid = null)
    {
        parent::__construct($manager, $formBuilder);
        $this->dataGrid = $dataGrid;
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
    
    public function editAction(int $id) : Response
    {
        $resource = $this->getManager()->getRepository()->find($id);
        
        if (!$resource instanceof EntityInterface) {
            return $this->redirectToAction('index');
        }
        
        $form = $this->getForm($resource);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($resource);
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
            $resource = $this->getManager()->getRepository()->findOneBy(['id' => $id]);
            $this->getManager()->removeResource($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getTraceAsString()]);
        }
        
        return $this->jsonResponse(['success' => true]);
    }
    
    protected function getOrderProvider() : OrderProviderInterface
    {
        return $this->get('order.provider.admin');
    }
    
    protected function getAuthenticatedAdmin() : UserInterface
    {
        return $this->getSecurityHelper()->getAuthenticatedAdmin();
    }
}
