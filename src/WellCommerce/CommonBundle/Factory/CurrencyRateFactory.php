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

namespace WellCommerce\CommonBundle\Factory;

use WellCommerce\CommonBundle\Entity\CurrencyRate;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class CurrencyRateFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRateFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CommonBundle\Entity\CurrencyRateInterface
     */
    public function create()
    {
        $currencyRate = new CurrencyRate();
        $currencyRate->setExchangeRate(1);

        return $currencyRate;
    }
}
