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
namespace WellCommerce\Plugin\Contact\Controller\Frontend;

use WellCommerce\Core\Controller\FrontendController;

/**
 * Class ContactController
 *
 * @package WellCommerce\Plugin\Contact\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactController extends FrontendController
{

    public function indexAction()
    {
        echo $this->getRequest()->getLocale();
        return [];
    }
}
