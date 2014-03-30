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
namespace WellCommerce\Plugin\HomePage\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;

/**
 * Class HomePageController
 *
 * @package WellCommerce\Plugin\HomePage\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HomePageController extends FrontendController
{

    public function indexAction()
    {
        return [
            'content' => $this->getLayoutManager()->renderLayout('HomePage')
        ];
    }
}
