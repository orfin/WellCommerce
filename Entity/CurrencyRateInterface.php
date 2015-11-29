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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Interface CurrencyRateInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyRateInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getCurrencyFrom();

    /**
     * @param string $currencyFrom
     */
    public function setCurrencyFrom($currencyFrom);

    /**
     * @return string
     */
    public function getCurrencyTo();

    /**
     * @param string $currencyTo
     */
    public function setCurrencyTo($currencyTo);

    /**
     * @return float
     */
    public function getExchangeRate();

    /**
     * @param float $exchangeRate
     */
    public function setExchangeRate($exchangeRate);
}
