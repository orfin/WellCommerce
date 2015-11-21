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

namespace WellCommerce\CommonBundle\Controller\Admin;

use WellCommerce\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ShopController
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopController extends AbstractAdminController
{
    /**
     * Action used to switch admin shop context
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeContextAction($id)
    {
        $shop = $this->manager->getRepository()->find($id);
        $this->get('shop.context.admin')->setCurrentScope($shop);

        return $this->jsonResponse([
            'success' => true
        ]);
    }
}
