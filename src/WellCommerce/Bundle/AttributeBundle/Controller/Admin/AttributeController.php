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
 * Class AttributeController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Manager\Admin\AttributeManager
     */
    protected $manager;

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
        $attributes = $this->manager->getRepository()->findAllByAttributeGroupId($id);

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
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

        try {
            $attribute = $this->manager->createAttribute();

            return $this->jsonResponse([
                'id' => $attribute->getId()
            ]);

        } catch (\Exception $e) {

            return $this->jsonResponse([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
