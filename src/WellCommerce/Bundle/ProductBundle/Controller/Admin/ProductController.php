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

namespace WellCommerce\Bundle\ProductBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ProductController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\ProductBundle\Manager\Admin\ProductManager
     */
    protected $manager;

    /**
     * Updates product data from DataGrid request
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request) : JsonResponse
    {
        $id   = $request->request->get('id');
        $data = $request->request->get('product');

        try {
            $this->manager->quickUpdateProduct($id, $data);
            $result = ['success' => $this->trans('product.flash.success.saved')];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage()];
        }

        return $this->jsonResponse($result);
    }
}
