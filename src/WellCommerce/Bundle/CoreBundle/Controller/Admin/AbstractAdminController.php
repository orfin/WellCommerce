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

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
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
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var null|DataGridInterface
     */
    protected $dataGrid;

    /**
     * @var null|FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * AbstractAdminController constructor.
     *
     * @param ManagerInterface          $manager
     * @param FormBuilderInterface|null $formBuilder
     * @param DataGridInterface|null    $dataGrid
     */
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
        $form     = $this->getForm($resource);
        
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
    
    public function editAction(int $id) : Response
    {
        $resource = $this->manager->getRepository()->find($id);
        if (!$resource instanceof EntityInterface) {
            return $this->redirectToAction('index');
        }
        
        $form = $this->getForm($resource);
        
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
            $resource = $this->manager->getRepository()->findOneBy(['id' => $id]);
            $this->manager->removeResource($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getTraceAsString()]);
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

    protected function getForm($resource, array $config = []) : FormInterface
    {
        $builder       = $this->getFormBuilder();
        $defaultConfig = [
            'name'              => $this->manager->getRepository()->getAlias(),
            'validation_groups' => ['Default']
        ];
        $config        = array_merge($defaultConfig, $config);

        return $builder->createForm($config, $resource);
    }

    protected function getFormBuilder() : FormBuilderInterface
    {
        return $this->formBuilder;
    }
}
