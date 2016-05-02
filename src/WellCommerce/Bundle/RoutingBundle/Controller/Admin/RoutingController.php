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
use WellCommerce\Bundle\RoutingBundle\Generator\SlugGeneratorInterface;

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
            return $this->redirectToAction('index');
        }

        $slug = $this->getSlugGenerator()->generate(
            $request->get('name'),
            $request->get('id'),
            $request->get('locale'),
            $request->get('fields')
        );

        $response = [
            'slug' => $slug
        ];

        return $this->jsonResponse($response);
    }

    private function getSlugGenerator() : SlugGeneratorInterface
    {
        return $this->get('slug.generator');
    }
}
