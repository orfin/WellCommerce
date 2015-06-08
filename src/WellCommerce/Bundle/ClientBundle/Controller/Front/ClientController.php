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
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ClientController extends AbstractFrontController implements FrontControllerInterface
{
    public function indexAction()
    {
        return [];
    }

    public function loginAction()
    {
        return [];
    }

    public function loginCheckAction(Request $request)
    {
    }

    public function registerAction()
    {
        return [];
    }

    public function settingsAction()
    {
        return [];
    }

    public function wishListAction()
    {
        return [];
    }

    public function addressBookAction()
    {
        return [];
    }

    public function ordersAction()
    {
        return [];
    }
}
