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

namespace WellCommerce\Bundle\MultiStoreBundle\Controller\Admin;

use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class ShopController
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
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
        $shop = $this->getManager()->getRepository()->find($id);
        $this->get('shop.context.admin')->setCurrentScope($shop);

        return $this->jsonResponse([
            'success' => true
        ]);
    }
}
