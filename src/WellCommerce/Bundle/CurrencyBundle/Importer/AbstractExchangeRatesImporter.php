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

namespace WellCommerce\Bundle\CurrencyBundle\Importer;

use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRateRepositoryInterface;
use WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRepositoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class AbstractExchangeRatesImporter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractExchangeRatesImporter
{
    /**
     * @var CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    /**
     * @var CurrencyRateRepositoryInterface
     */
    protected $ratesRepository;

    /**
     * @var DoctrineHelperInterface
     */
    protected $helper;

    /**
     * @var array
     */
    protected $managedCurrencies = [];

    /**
     * Constructor
     *
     * @param CurrencyRepositoryInterface     $currencyRepository
     * @param CurrencyRateRepositoryInterface $ratesRepository
     * @param DoctrineHelperInterface         $helper
     */
    public function __construct(
        CurrencyRepositoryInterface $currencyRepository,
        CurrencyRateRepositoryInterface $ratesRepository,
        DoctrineHelperInterface $helper
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->ratesRepository    = $ratesRepository;
        $this->helper             = $helper;

        $this->setManagedCurrencies();
    }

    /**
     * Adds new rate or updates existing one
     *
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float  $rate
     */
    protected function addUpdateExchangeRate($currencyFrom, $currencyTo, $rate)
    {
        if (!in_array($currencyTo, $this->managedCurrencies)) {
            return false;
        }

        $exchangeRate = $this->ratesRepository->findOneBy([
            'currencyFrom' => $currencyFrom,
            'currencyTo'   => $currencyTo
        ]);

        if (null === $exchangeRate) {
            $exchangeRate = new CurrencyRate();
            $exchangeRate->setCurrencyFrom($currencyFrom);
            $exchangeRate->setCurrencyTo($currencyTo);
            $exchangeRate->setExchangeRate($rate);
            $this->helper->getEntityManager()->persist($exchangeRate);
        } else {
            $exchangeRate->setExchangeRate($rate);
        }

        return true;
    }

    /**
     * Sets all managed currencies
     */
    protected function setManagedCurrencies()
    {
        foreach ($this->getCurrencies() as $currency) {
            $this->managedCurrencies[] = $currency->getCode();
        }
    }

    /**
     * Returns all currencies from repository
     *
     * @return \WellCommerce\Bundle\CurrencyBundle\Entity\Currency[]
     */
    protected function getCurrencies()
    {
        return $this->currencyRepository->findAll();
    }

    /**
     * Formats the exchange rate
     *
     * @param float $rate
     *
     * @return string
     */
    protected function formatExchangeRate($rate)
    {
        return number_format($rate, 4, '.', '');
    }
}
