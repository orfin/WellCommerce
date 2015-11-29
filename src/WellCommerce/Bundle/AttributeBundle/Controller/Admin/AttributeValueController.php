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

namespace WellCommerce\Bundle\AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class AttributeValueController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AppBundle\Manager\Admin\AttributeValueManager
     */
    protected $manager;

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

        $attributeValueName = $request->request->get('name');
        $attributeId        = (int)$request->request->get('attribute');
        $value              = $this->manager->addAttributeValue($attributeValueName, $attributeId);

        return $this->jsonResponse([
            'id' => $value->getId(),
        ]);
    }
}
