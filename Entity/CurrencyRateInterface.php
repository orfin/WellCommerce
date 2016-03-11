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

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface CurrencyRateInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyRateInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getCurrencyFrom() : string;

    /**
     * @param string $currencyFrom
     */
    public function setCurrencyFrom(string $currencyFrom);

    /**
     * @return string
     */
    public function getCurrencyTo() : string;

    /**
     * @param string $currencyTo
     */
    public function setCurrencyTo(string $currencyTo);

    /**
     * @return float
     */
    public function getExchangeRate() : float;

    /**
     * @param float $exchangeRate
     */
    public function setExchangeRate(float $exchangeRate);
}
