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
     * Ajax action for listing attributes in variants editor
     *
     * @param Request $request
     *
     * @return Response
     */
    public function ajaxIndexAction(Request $request) : Response
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
     * @return Response
     */
    public function ajaxAddAction(Request $request) : Response
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
