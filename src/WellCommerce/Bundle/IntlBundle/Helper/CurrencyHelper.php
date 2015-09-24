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

namespace WellCommerce\Bundle\IntlBundle\Helper;

use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;
use WellCommerce\Bundle\IntlBundle\Formatter\CurrencyFormatterInterface;

/**
 * Class CurrencyHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyHelper implements CurrencyHelperInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    protected $converter;

    /**
     * @var CurrencyFormatterInterface
     */
    protected $formatter;

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

    /**
     * {@inheritdoc}
     */
    public function format($amount, $currency = null, $locale = null)
    {
        return $this->formatter->format($amount, $currency, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function convert($amount, $baseCurrency = null, $targetCurrency = null, $quantity = 1)
    {
        return $this->converter->convert($amount, $baseCurrency, $targetCurrency, $quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function convertAndFormat($amount, $baseCurrency = null, $targetCurrency = null, $quantity = 1, $locale = null)
    {
        $converted = $this->convert($amount, $baseCurrency, $targetCurrency, $quantity);

        return $this->format($converted, $targetCurrency, $locale);
    }
}
