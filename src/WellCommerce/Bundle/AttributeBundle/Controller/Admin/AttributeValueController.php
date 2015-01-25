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
 * Class AttributeValueController
 *
 * @package WellCommerce\Bundle\AttributeBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepositoryInterface
     */
    protected $repository;

    /**
     * Adds new attribute value using ajax request
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    /**
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

        $attribute = $this->get('attribute.repository')->find($request->request->get('attribute'));
        $value     = $this->getRepository()->addAttributeValue($attribute, $request->request->get('name'));
        $this->getEntityManager()->flush();

        return $this->jsonResponse([
            'id' => $value->getId(),
        ]);
    }

    /**
     * @return \WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepository
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository();
    }
}
