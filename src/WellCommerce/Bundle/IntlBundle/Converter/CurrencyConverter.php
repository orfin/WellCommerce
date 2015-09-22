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

namespace WellCommerce\Bundle\IntlBundle\Converter;

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\IntlBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\IntlBundle\Repository\CurrencyRateRepositoryInterface;

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
    public function convert($amount, $baseCurrency = null, $targetCurrency = null)
    {
        if (null === $baseCurrency) {
            $baseCurrency = $this->requestHelper->getCurrentCurrency();
        }

        if (null === $targetCurrency) {
            $targetCurrency = $this->requestHelper->getCurrentCurrency();
        }

        $this->loadExchangeRates($targetCurrency);

        $exchangeRate = $this->exchangeRates[$targetCurrency][$baseCurrency];

        return $amount * $exchangeRate;
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
                throw new \RuntimeException(sprintf('There are no exchange rates for "%s"', $targetCurrency));
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
