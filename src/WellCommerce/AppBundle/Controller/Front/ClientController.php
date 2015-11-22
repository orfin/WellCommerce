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

namespace WellCommerce\AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\AppBundle\Controller\Front\AbstractFrontController;
use WellCommerce\AppBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ClientController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientController extends AbstractFrontController implements FrontControllerInterface
{
    public function loginAction()
    {
        return $this->displayTemplate('login');
    }

    public function loginCheckAction(Request $request)
    {
    }
}
