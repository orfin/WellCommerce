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

use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRateInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CurrencyRateFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRateFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CurrencyRateInterface::class;

    /**
     * @return CurrencyRateInterface
     */
    public function create() : CurrencyRateInterface
    {
        /** @var $currencyRate CurrencyRateInterface */
        $currencyRate = $this->init();
        $currencyRate->setExchangeRate(1);
        $currencyRate->setCurrencyFrom('');
        $currencyRate->setCurrencyTo('');

        return $currencyRate;
    }
}
