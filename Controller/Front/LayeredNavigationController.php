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

namespace WellCommerce\Bundle\LayeredNavigationBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class LayeredNavigationController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayeredNavigationController extends AbstractFrontController
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function filterAction()
    {
        $redirectUrl = $this->get('layered_navigation.helper')->generateRedirectUrl();

        return $this->jsonResponse([
            'success'     => true,
            'redirectUrl' => $redirectUrl,
        ]);
    }
}
