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
namespace WellCommerce\Contact\Controller\Front;

use WellCommerce\Core\Controller\Front\AbstractFrontController;

/**
 * Class ContactController
 *
 * @package WellCommerce\Contact\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactController extends AbstractFrontController
{
    public function indexAction()
    {
        return [
            'layout' => $this->renderLayout()
        ];
    }
}
