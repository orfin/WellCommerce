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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\AttributeBundle\Generator\CartesianProductGenerator;
use WellCommerce\Bundle\AttributeBundle\Manager\AttributeManager;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class AttributeController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeController extends AbstractAdminController
{

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
        $attributeGroup   = $this->getManager()->findAttributeGroup($attributeGroupId);

        return $this->jsonResponse([
            'attributes' => $this->getManager()->getAttributeSet($attributeGroup),
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
            $attribute = $this->getManager()->createAttribute($attributeName, $attributeGroupId);
            
            return $this->jsonResponse([
                'id' => $attribute->getId()
            ]);
            
        } catch (\Exception $e) {
            
            return $this->jsonResponse([
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function ajaxGenerateCartesianAction(Request $request) : JsonResponse
    {
        $attributes    = $request->request->get('attributes');
        $attributesMap = [];
        
        foreach ($attributes as $attribute) {
            $attributesMap[$attribute['attribute']][] = $attribute['value'];
        }
        
        $variantsCombinations = CartesianProductGenerator::generateCartesianProduct($attributesMap);
        
        return $this->jsonResponse([
            'variants' => $variantsCombinations
        ]);
    }

    protected function getManager() : AttributeManager
    {
        return parent::getManager();
    }
}
