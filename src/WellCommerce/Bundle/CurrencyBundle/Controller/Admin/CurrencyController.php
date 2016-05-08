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

namespace WellCommerce\Bundle\CurrencyBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\RedirectResponse;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class CurrencyController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyController extends AbstractAdminController
{
    public function syncExchangeRatesAction() : RedirectResponse
    {
        $this->get('currency.importer.ecb')->importExchangeRates();
        $this->getFlashHelper()->addSuccess('currency.flashes.success.exchange_rates_synchronization');

        return $this->redirectToAction('index');
    }
}
