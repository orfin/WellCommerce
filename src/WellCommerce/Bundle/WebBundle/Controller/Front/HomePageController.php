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
use WellCommerce\Bundle\LayoutBundle\Manager\Layout;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class UnitController
 *
 * @package WellCommerce\Bundle\UnitBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 * @Layout(name="HomePage")
 */
class HomePageController extends AbstractFrontController implements FrontControllerInterface
{

    public function indexAction(Request $request)
    {
        return [
            'layout' => $this->renderLayout()
        ];
    }

}
