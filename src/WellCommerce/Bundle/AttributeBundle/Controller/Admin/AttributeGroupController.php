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
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class AttributeGroupController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class AttributeGroupController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $groups = $this->getManager()->getRepository()->findAll();

        if (count($groups) > 0) {
            $firstGroup = current($groups);

            return $this->redirectToAction('edit', [
                'id' => $firstGroup['id']
            ]);
        }

        return [
            'groups' => $groups
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction(Request $request)
    {
        $name     = $request->request->get('name');
        $locales  = $this->get('locale.repository')->findAll();
        $resource = $this->getManager()->initResource();

        foreach ($locales as $locale) {
            $resource->translate($locale->getCode())->setName($name);
        }

        $resource->mergeNewTranslations();

        $this->getManager()->createResource($resource, $request);

        return $this->jsonResponse([
            'id' => $resource->getId(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function editAction(Request $request)
    {
        $groups   = $this->getManager()->getRepository()->findAll();
        $resource = $this->getManager()->findResource($request);
        $form     = $this->getManager()->getForm($resource, [
            'class' => 'attributeGroupEditor'
        ]);

        if ($form->handleRequest()->isValid()) {
            $this->getManager()->updateResource($resource, $request);
            if ($form->isAction('continue')) {
                return $this->getManager()->getRedirectHelper()->redirectToAction('edit', [
                    'id' => $resource->getId()
                ]);
            }

            return $this->redirectToAction('index');
        }

        return [
            'currentGroup' => $resource,
            'groups'       => $groups,
            'form'         => $form
        ];
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

        $groups = $this->getManager()->getRepository()->findAll();
        $sets   = [];

        foreach ($groups as $group) {
            $sets[] = [
                'id'               => $group['id'],
                'name'             => $group['name'],
                'current_category' => false,
            ];
        }

        $response = [
            'sets' => $sets,
        ];

        return $this->jsonResponse($response);
    }
}
