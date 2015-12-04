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

namespace WellCommerce\Bundle\CurrencyBundle\Converter;

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\CurrencyBundle\Exception\MissingCurrencyRateException;
use WellCommerce\Bundle\CurrencyBundle\Exception\MissingCurrencyRatesException;
use WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRateRepositoryInterface;

/**
 * Class CurrencyConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyConverter implements CurrencyConverterInterface
{
    /**
     * @var CurrencyRateRepositoryInterface
     */
    protected $currencyRateRepository;

    /**
     * @var array
     */
    protected $exchangeRates = [];

    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * Constructor
     *
     * @param CurrencyRateRepositoryInterface $currencyRateRepository
     * @param RequestHelperInterface          $requestHelper
     */
    public function __construct(CurrencyRateRepositoryInterface $currencyRateRepository, RequestHelperInterface $requestHelper)
    {
        $this->currencyRateRepository = $currencyRateRepository;
        $this->requestHelper          = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($amount, $baseCurrency = null, $targetCurrency = null, $quantity = 1)
    {
        $exchangeRate    = $this->getExchangeRate($baseCurrency, $targetCurrency);
        $exchangedAmount = round($amount * $exchangeRate, 2);

        return round($exchangedAmount * $quantity, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function getExchangeRate($baseCurrency = null, $targetCurrency = null)
    {
        $baseCurrency   = (null === $baseCurrency) ? $this->requestHelper->getCurrentCurrency() : $baseCurrency;
        $targetCurrency = (null === $targetCurrency) ? $this->requestHelper->getCurrentCurrency() : $targetCurrency;

        $this->loadExchangeRates($targetCurrency);

        if (!isset($this->exchangeRates[$targetCurrency][$baseCurrency])) {
            throw new MissingCurrencyRateException($baseCurrency, $targetCurrency);
        }

        return $this->exchangeRates[$targetCurrency][$baseCurrency];
    }

    /**
     * Sets exchange rates for target currency
     *
     * @param string $targetCurrency
     */
    protected function loadExchangeRates($targetCurrency)
    {
        if (!isset($this->exchangeRates[$targetCurrency])) {
            $currencyRates = $this->currencyRateRepository->findBy(['currencyTo' => $targetCurrency]);
            if (count($currencyRates) === 0) {
                throw new MissingCurrencyRatesException($targetCurrency);
            }
            foreach ($currencyRates as $rate) {
                $this->setExchangeRate($rate, $targetCurrency);
            }
        }
    }

    /**
     * Sets exchange rate for target and base currency pair
     *
     * @param CurrencyRate $rate
     * @param string       $targetCurrency
     */
    protected function setExchangeRate(CurrencyRate $rate, $targetCurrency)
    {
        $this->exchangeRates[$targetCurrency][$rate->getCurrencyFrom()] = $rate->getExchangeRate();
    }
}
