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

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;
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
     * Constructor
     *
     * @param CurrencyConverterInterface $converter
     * @param CurrencyProviderInterface  $provider
     */
    public function __construct(CurrencyConverterInterface $converter, CurrencyProviderInterface $provider)
    {
        $this->converter = $converter;
        $this->provider  = $provider;
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

    public function formatPrice($price, $currencyFrom = null, $currencyTo = null)
    {
        return $this->converter->format($price, $currencyFrom, $currencyTo);
    }

    public function convertPrice($price, $currencyFrom = null, $currencyTo = null)
    {
        return $this->converter->convert($price, $currencyFrom, $currencyTo);
    }
}
