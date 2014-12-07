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
 * Class AttributeController
 *
 * @package WellCommerce\Bundle\AttributeBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function ajaxIndexAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        $attributes = $this->manager->getRepository()->findAllByAttributeGroupId($request->request->get('id'));

        $sets = [];

        foreach ($attributes as $attribute) {
            $sets[] = [
                'id'     => $attribute['id'],
                'name'   => $attribute['name'],
                'values' => $attribute['values'],
            ];
        }

        $response = [
            'attributes' => $sets
        ];

        return $this->jsonResponse($response);
    }

    /**
     * Adds new attribute value using ajax request
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ajaxAddAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return false;
        }

        $group     = $this->get('attribute_group.repository')->find($request->request->get('set'));
        $attribute = $this->repository->createNewAttribute($group, $request->request->get('name'));

        $this->getEntityManager()->persist($attribute);
        $this->getEntityManager()->flush();

        return $this->jsonResponse([
            'id' => $attribute->getId()
        ]);
    }
}
