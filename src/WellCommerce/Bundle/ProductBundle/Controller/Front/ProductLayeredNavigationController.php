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

namespace WellCommerce\Bundle\ProductBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ProductLayeredNavigationController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductLayeredNavigationController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function filterAction()
    {
        $redirectUrl = $this->get('product_layered_navigation.helper')->generateRedirectUrl();

        return $this->jsonResponse([
            'success'     => true,
            'redirectUrl' => $redirectUrl,
        ]);
    }
}
