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

namespace WellCommerce\Bundle\IntlBundle\Entity;

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
     * @return CurrencyInterface
     */
    public function getCurrencyFrom();

    /**
     * @param CurrencyInterface $currencyFrom
     */
    public function setCurrencyFrom(CurrencyInterface $currencyFrom);

    /**
     * @return CurrencyInterface
     */
    public function getCurrencyTo();

    /**
     * @param CurrencyInterface $currencyTo
     */
    public function setCurrencyTo(CurrencyInterface $currencyTo);

    /**
     * @return float
     */
    public function getExchangeRate();

    /**
     * @param float $exchangeRate
     */
    public function setExchangeRate($exchangeRate);
}
