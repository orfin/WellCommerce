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

namespace WellCommerce\Bundle\WebBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class UnitController
 *
 * @package WellCommerce\Bundle\UnitBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HomePageController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('WellCommerceWebBundle:Front/HomePage:index.html.twig');
    }

}
