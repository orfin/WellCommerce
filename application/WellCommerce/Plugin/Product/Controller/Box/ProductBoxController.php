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

namespace WellCommerce\Plugin\Product\Controller\Box;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Core\Component\Controller\Box\AbstractBoxController;
use WellCommerce\Plugin\Product\Repository\ProductRepositoryInterface;

/**
 * Class ProductBoxController
 *
 * @package WellCommerce\Plugin\Product\Controller\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $product = $this->get('product.provider')->getCurrent();

        return [
            'product' => $product
        ];
    }
}