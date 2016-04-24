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

namespace WellCommerce\Bundle\CurrencyBundle\Helper;

use WellCommerce\Bundle\CurrencyBundle\Converter\CurrencyConverterInterface;
use WellCommerce\Bundle\CurrencyBundle\Formatter\CurrencyFormatterInterface;

/**
 * Class CurrencyHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CurrencyHelper implements CurrencyHelperInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    private $converter;

    /**
     * @var CurrencyFormatterInterface
     */
    private $formatter;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface $converter
     * @param CurrencyFormatterInterface $formatter
     */
    public function __construct(CurrencyConverterInterface $converter, CurrencyFormatterInterface $formatter)
    {
        $this->converter = $converter;
        $this->formatter = $formatter;
    }

    public function format(float $amount, string $currency = null, string $locale = null) : string
    {
        return $this->formatter->format($amount, $currency, $locale);
    }

    public function convert(float $amount, string $baseCurrency = null, string $targetCurrency = null, int $quantity = 1) : float
    {
        return $this->converter->convert($amount, $baseCurrency, $targetCurrency, $quantity);
    }

    public function convertAndFormat(
        float $amount,
        string $baseCurrency = null,
        string $targetCurrency = null,
        int $quantity = 1,
        string $locale = null
    ) : string
    {
        $converted = $this->convert($amount, $baseCurrency, $targetCurrency, $quantity);

        return $this->format($converted, $targetCurrency, $locale);
    }

    public function getCurrencyRate(string $baseCurrency = null, string $targetCurrency = null) : float
    {
        return $this->converter->getExchangeRate($baseCurrency, $targetCurrency);
    }
}
