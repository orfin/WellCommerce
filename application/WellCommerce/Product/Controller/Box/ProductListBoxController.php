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

namespace WellCommerce\Product\Controller\Box;

use WellCommerce\Core\Controller\Box\AbstractBoxController;

/**
 * Class ProductListBoxController
 *
 * @package WellCommerce\Product\Controller\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductListBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $product = $this->get('product.provider')->getCurrent();

        return [
            'product' => $product
        ];
    }
}