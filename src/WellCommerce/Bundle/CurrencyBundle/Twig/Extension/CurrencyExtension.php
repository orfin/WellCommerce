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
namespace WellCommerce\Bundle\CurrencyBundle\Twig\Extension;

use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class CurrencyExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $helper;

    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface $helper
     * @param DataSetInterface        $dataset
     */
    public function __construct(CurrencyHelperInterface $helper, DataSetInterface $dataset)
    {
        $this->helper  = $helper;
        $this->dataset = $dataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('format_price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('convert_price', [$this, 'convertPrice'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('currencies', [$this, 'getCurrencies'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns an array of currencies
     *
     * @return array
     */
    public function getCurrencies() : array
    {
        return $this->dataset->getResult('select', ['order_by' => 'code'], ['label_column' => 'code']);
    }

    /**
     * Formats the given amount
     *
     * @param int|float   $price
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     * @param null|string $locale
     *
     * @return string
     */
    public function formatPrice(float $price, $baseCurrency = null, $targetCurrency = null, $locale = null, $quantity = 1) : string
    {
        return $this->helper->convertAndFormat($price, $baseCurrency, $targetCurrency, $quantity, $locale);
    }

    /**
     * Converts the given amount
     *
     * @param float       $price
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     * @param int         $quantity
     *
     * @return string
     */
    public function convertPrice(float $price, $baseCurrency = null, $targetCurrency = null, $quantity = 1) : string
    {
        return $this->helper->convert($price, $baseCurrency, $targetCurrency, $quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'currency';
    }
}
