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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class ProductController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends AbstractAdminController
{
    /**
     * Updates product data from DataGrid request
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction(Request $request)
    {
        $id        = $request->request->get('id');
        $data      = $request->request->get('row');
        $product   = $this->getManager()->getRepository()->find($id);
        $validator = $this->get('validator');

        if (null === $product) {
            return $this->jsonResponse(['error' => $this->trans('product.flash.error.not_found')]);
        }

        $product->setSku($data['sku']);
        $product->setWeight($data['weight']);
        $product->setStock($data['stock']);
        $product->getSellPrice()->setAmount($data['sellPrice']);

        $errors = $validator->validate($product);
        if ($errors->count()) {
            return $this->jsonResponse(['error' => (string)$errors]);
        }

        $this->getManager()->getDoctrineHelper()->getEntityManager()->flush();

        return $this->jsonResponse(['success' => $this->trans('product.flash.success.saved')]);
    }
}
