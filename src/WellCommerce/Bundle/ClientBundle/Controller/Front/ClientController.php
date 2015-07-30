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

namespace WellCommerce\Bundle\ClientBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ClientController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientController extends AbstractFrontController implements FrontControllerInterface
{
    public function loginAction()
    {
        return $this->display('login');
    }

    public function loginCheckAction(Request $request)
    {
    }

    public function registerAction()
    {
        return $this->display('register');
    }

    public function settingsAction()
    {
        return $this->render('WellCommerceClientBundle:Front/Client:settings.html.twig');
    }

    public function wishListAction()
    {
        return $this->display('wishlist');
    }

    public function addressBookAction()
    {
        return $this->display('address_book');
    }

    public function ordersAction()
    {
        return $this->display('orders');
    }
}
