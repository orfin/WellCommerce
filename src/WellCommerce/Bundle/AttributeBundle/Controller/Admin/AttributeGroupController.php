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
    
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $groups = $this->manager->getGroupsCollection();

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
    
    /**
     * {@inheritdoc}
     */
    public function addAction(Request $request)
    {
        $name     = $request->request->get('name');
        $resource = $this->manager->createGroup($name);
        
        return $this->jsonResponse([
            'id' => $resource->getId(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function editAction(Request $request)
    {
        $resource = $this->manager->findResource($request);
        if (null === $resource) {
            return $this->redirectToAction('index');
        }

        $groups = $this->manager->getGroupsCollection();
        $form   = $this->manager->getForm($resource, ['class' => 'attributeGroupEditor']);
        
        if ($form->handleRequest()->isValid()) {
            $this->manager->updateResource($resource);
            if ($form->isAction('continue')) {
                return $this->getRouterHelper()->redirectToAction('edit', ['id' => $resource->getId()]);
            }
            
            return $this->redirectToAction('index');
        }
        
        return $this->displayTemplate('edit', [
            'currentGroup' => $resource,
            'groups'       => $groups,
            'form'         => $form
        ]);
    }
    
    /**
     * Returns all attribute groups as json
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ajaxIndexAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }
        
        return $this->jsonResponse([
            'sets' => $this->manager->getAttributeGroupSet()
        ]);
    }
}
