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

namespace WellCommerce\Bundle\ShopBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ShopController
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopController extends AbstractAdminController
{
    public function switchShopAction(int $id) : JsonResponse
    {
        $this->getRequestHelper()->setSessionAttribute('admin/shop/id', $id);

        return $this->jsonResponse([
            'success' => true
        ]);
    }
}
