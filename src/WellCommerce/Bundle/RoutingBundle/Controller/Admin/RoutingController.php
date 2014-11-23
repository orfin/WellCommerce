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
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class RoutingController
 *
 * @package WellCommerce\Bundle\RoutingBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class RoutingController extends AbstractAdminController
{
    /**
     * Action used to generate slug
     *
     * @param Request $request
     */
    public function generateAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        $slug = $this->manager->getRepository()->generateSlug(
            $request->get('name'),
            $request->get('id'),
            $request->get('locale'),
            $request->get('fields')
        );

        $response = [
            'slug' => $slug
        ];

        return new JsonResponse($response);
    }
}
