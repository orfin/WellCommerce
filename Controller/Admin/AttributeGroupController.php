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

namespace WellCommerce\Bundle\AttributeBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class AttributeGroupController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Manager\Admin\AttributeGroupManager
     */
    protected $manager;
    
    public function indexAction() : Response
    {
        $groups = $this->manager->getAttributeGroupsCollection();

        if ($groups->count()) {
            $defaultGroup = $groups->first();

            return $this->redirectToAction('edit', [
                'id' => $defaultGroup->getId()
            ]);
        }

        return $this->displayTemplate('index', [
            'groups' => $groups
        ]);
    }
    
    public function addAction(Request $request) : Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

        $name     = $request->request->get('name');
        $resource = $this->manager->createAttributeGroup($name);
        
        return $this->jsonResponse([
            'id' => $resource->getId(),
        ]);
    }
    
    public function editAction(Request $request) : Response
    {
        $resource = $this->manager->findResource($request);
        if (null === $resource) {
            return $this->redirectToAction('index');
        }

        $groups = $this->manager->getAttributeGroupsCollection();
        $form   = $this->manager->getForm($resource, [
            'class' => 'attributeGroupEditor'
        ]);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('edit', [
            'resource' => $resource,
            'groups'   => $groups,
            'form'     => $form
        ]);
    }
    
    public function ajaxIndexAction(Request $request) : Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }
        
        return $this->jsonResponse([
            'sets' => $this->manager->getAttributeGroupSet()
        ]);
    }
}
