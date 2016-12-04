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

namespace WellCommerce\Bundle\CurrencyBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface CurrencyRateInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyRateInterface extends EntityInterface
{
    public function getCurrencyFrom() : string;
    
    public function setCurrencyFrom(string $currencyFrom);
    
    public function getCurrencyTo() : string;

    public function setCurrencyTo(string $currencyTo);

    public function getExchangeRate() : float;

    public function setExchangeRate(float $exchangeRate);
}
