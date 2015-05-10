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

use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @var SessionInterface
     */
    protected $session;

    /**
     * Constructor
     *
     * @param CurrencyRateRepositoryInterface $currencyRateRepository
     * @param SessionInterface                $session
     */
    public function __construct(CurrencyRateRepositoryInterface $currencyRateRepository, SessionInterface $session)
    {
        $this->currencyRateRepository = $currencyRateRepository;
        $this->session                = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($amount, $baseCurrency, $targetCurrency = null)
    {
        if (null === $targetCurrency) {

        }
    }
}