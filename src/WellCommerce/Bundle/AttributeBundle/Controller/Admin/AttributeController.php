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
     * Ajax action for listing attributes
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ajaxIndexAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

        $id         = $request->request->get('id');
        $attributes = $this->getRepository()->findAllByAttributeGroupId($id);

        $sets = [];

        foreach ($attributes as $attribute) {
            $sets[] = [
                'id'     => $attribute['id'],
                'name'   => $attribute['name'],
                'values' => $attribute['values'],
            ];
        }

        return $this->jsonResponse([
            'attributes' => $sets,
        ]);
    }

    /**
     * Adds new attribute value using ajax request
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ajaxAddAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

        $group     = $this->get('attribute_group.repository')->find($request->request->get('set'));
        $attribute = $this->getRepository()->createNewAttribute($group, $request->request->get('name'));

        $em = $this->getEntityManager();
        $em->persist($attribute);
        $em->flush();

        return $this->jsonResponse([
            'id' => $attribute->getId(),
        ]);
    }

    /**
     * Returns attribute repository
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository();
    }
}
