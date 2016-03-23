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

namespace WellCommerce\Bundle\LocaleBundle\Controller\Front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class LocaleController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleController extends AbstractFrontController
{
    /**
     * Redirects to home page
     *
     * @return RedirectResponse
     */
    public function switchAction() : RedirectResponse
    {
        return $this->redirectToRoute('front.home_page.index');
    }
}
