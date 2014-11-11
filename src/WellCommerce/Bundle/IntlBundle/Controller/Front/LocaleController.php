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

namespace WellCommerce\Bundle\IntlBundle\Controller\Front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class LocaleController
 *
 * @package WellCommerce\Bundle\IntlBundle\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * Switch current language
     *
     * @param Request $request
     * @param         $locale
     */
    public function switchAction()
    {
        return new RedirectResponse($this->generateUrl('front.home_page.index'));
    }
}
