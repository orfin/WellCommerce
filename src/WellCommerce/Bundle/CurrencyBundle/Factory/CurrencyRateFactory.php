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

namespace WellCommerce\Bundle\CurrencyBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRateInterface;

/**
 * Class CurrencyRateFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRateFactory extends AbstractEntityFactory
{
    public function create() : CurrencyRateInterface
    {
        $currencyRate = new CurrencyRate();
        $currencyRate->setExchangeRate(1);
        $currencyRate->setCurrencyFrom('');
        $currencyRate->setCurrencyTo('');

        return $currencyRate;
    }
}
