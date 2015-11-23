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

namespace WellCommerce\AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\AppBundle\Controller\Admin\AbstractAdminController;

/**
 * Class AttributeController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\AppBundle\Manager\Admin\AttributeManager
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
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToAction('index');
        }

        $attributeGroupId = (int)$request->request->get('id');

        return $this->jsonResponse([
            'attributes' => $this->manager->getAttributeSet($attributeGroupId),
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

        $attributeName    = $request->request->get('name');
        $attributeGroupId = (int)$request->request->get('set');

        try {
            $attribute = $this->manager->createAttribute($attributeName, $attributeGroupId);

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
