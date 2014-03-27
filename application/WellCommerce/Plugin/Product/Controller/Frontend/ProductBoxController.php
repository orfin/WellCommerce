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

namespace WellCommerce\Plugin\Product\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Response;

class ProductBoxController extends FrontendController
{

    public function indexAction($slug)
    {
        return new Response($slug);
    }
} 