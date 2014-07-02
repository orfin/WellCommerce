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

namespace WellCommerce\Plugin\Cart\Controller\Box;

use WellCommerce\Core\Component\Controller\Box\AbstractBoxController;

/**
 * Class CartBoxController
 *
 * @package WellCommerce\Plugin\Cart\Controller\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartBoxController extends AbstractBoxController
{

    public function indexAction()
    {
        return [
            'categories' => $this->getRepository()->getCategoriesTree()
        ];
    }
}