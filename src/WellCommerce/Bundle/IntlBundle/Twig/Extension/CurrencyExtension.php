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
namespace WellCommerce\Bundle\IntlBundle\Twig\Extension;

use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;
use WellCommerce\Bundle\IntlBundle\Formatter\CurrencyFormatterInterface;
use WellCommerce\Bundle\IntlBundle\Provider\CurrencyProviderInterface;

/**
 * Class CurrencyExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtension extends \Twig_Extension
{
    /**
     * @var CurrencyConverterInterface
     */
    protected $converter;

    /**
     * @var CurrencyProviderInterface
     */
    protected $provider;

    /**
     * @var CurrencyFormatterInterface
     */
    protected $formatter;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface $converter
     * @param CurrencyProviderInterface  $provider
     * @param CurrencyFormatterInterface $currencyFormatter
     */
    public function __construct(CurrencyConverterInterface $converter, CurrencyProviderInterface $provider, CurrencyFormatterInterface $currencyFormatter)
    {
        $this->converter = $converter;
        $this->provider  = $provider;
        $this->formatter = $currencyFormatter;
    }

    public function getGlobals()
    {
        return [
            'currencies' => $this->provider->getSelect()
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('format_price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('convert_price', [$this, 'convertPrice'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'currency';
    }

    /**
     * Formats the amount
     *
     * @param int|float   $price
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     * @param null|string $locale
     *
     * @return string
     */
    public function formatPrice($price, $baseCurrency = null, $targetCurrency = null, $locale = null)
    {
        $price = $this->convertPrice($price, $baseCurrency, $targetCurrency);

        return $this->formatter->format($price, $targetCurrency, $locale);
    }

    /**
     * Converts the amount
     *
     * @param int|float   $price
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     *
     * @return string
     */
    public function convertPrice($price, $baseCurrency = null, $targetCurrency = null)
    {
        return $this->converter->convert($price, $baseCurrency, $targetCurrency);
    }
}
