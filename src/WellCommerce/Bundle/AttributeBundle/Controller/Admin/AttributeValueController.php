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
 * Class AttributeValueController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Manager\AttributeValueManager
     */
    protected $manager;

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

        $attributeValueName = $request->request->get('name');
        $attributeId        = $request->request->get('attribute');
        $value              = $this->manager->addAttributeValue($attributeValueName, $attributeId);

        return $this->jsonResponse([
            'id' => $value->getId(),
        ]);
    }
}
