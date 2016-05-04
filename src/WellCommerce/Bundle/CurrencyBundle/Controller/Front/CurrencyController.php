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

namespace WellCommerce\Bundle\CurrencyBundle\Controller\Front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class CurrencyController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CurrencyController extends AbstractFrontController
{
    /**
     * Sets new session currency
     *
     * @param Request $request
     * @param string  $currency
     *
     * @return RedirectResponse
     */
    public function switchAction(Request $request, string $currency) : RedirectResponse
    {
        $result = $this->get('currency.repository')->findOneBy(['code' => $currency]);
        if (null !== $result) {
            $request->getSession()->set('_currency', $currency);
        }

        return new RedirectResponse($request->headers->get('referer'));
    }
}
