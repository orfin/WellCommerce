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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRateInterface;

/**
 * Class CurrencyRateFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRateFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CurrencyRateInterface::class;

    /**
     * @return CurrencyRateInterface
     */
    public function create()
    {
        /** @var $currencyRate CurrencyRateInterface */
        $currencyRate = $this->init();
        $currencyRate->setExchangeRate(1);

        return $currencyRate;
    }
}
