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

use WellCommerce\Bundle\IntlBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\IntlBundle\Provider\CurrencyProviderInterface;

/**
 * Class CurrencyExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtension extends \Twig_Extension
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $helper;

    /**
     * @var CurrencyProviderInterface
     */
    protected $provider;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface   $helper
     * @param CurrencyProviderInterface $provider
     */
    public function __construct(CurrencyHelperInterface $helper, CurrencyProviderInterface $provider)
    {
        $this->helper   = $helper;
        $this->provider = $provider;
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
    public function formatPrice($price, $baseCurrency = null, $targetCurrency = null, $locale = null, $quantity = 1)
    {
        return $this->helper->convertAndFormat($price, $baseCurrency, $targetCurrency, $quantity, $locale);
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
    public function convertPrice($price, $baseCurrency = null, $targetCurrency = null, $quantity = 1)
    {
        return $this->helper->convert($price, $baseCurrency, $targetCurrency, $quantity);
    }
}
