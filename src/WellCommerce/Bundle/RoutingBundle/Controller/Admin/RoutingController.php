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

namespace WellCommerce\Bundle\RoutingBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class RoutingController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutingController extends AbstractAdminController
{
    /**
     * Generates slug using ajax request
     *
     * @param Request $request
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function generateAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->getManager()->getRedirectHelper()->redirectToAction('index');
        }

        $response = [
            'slug' => $this->generateSlugFromRequest($request),
        ];

        return $this->jsonResponse($response);
    }

    /**
     * Returns route repository
     *
     * @return \WellCommerce\Bundle\RoutingBundle\Repository\RouteRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository();
    }

    /**
     * Generates route slug
     *
     * @param Request $request
     *
     * @return string
     */
    protected function generateSlugFromRequest(Request $request)
    {
        return $this->getRepository()->generateSlug(
            $request->get('name'),
            $request->get('id'),
            $request->get('locale'),
            $request->get('fields')
        );
    }
}
