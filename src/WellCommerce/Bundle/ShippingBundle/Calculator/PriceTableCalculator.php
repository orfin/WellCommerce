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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CurrencyBundle\Converter\CurrencyConverterInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class PriceTableCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PriceTableCalculator implements ShippingCalculatorInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * PriceTableCalculator constructor.
     *
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    public function calculate(ShippingMethodInterface $shippingMethod, ShippingSubjectInterface $subject) : Collection
    {
        $ranges         = $shippingMethod->getCosts();
        $baseCurrency   = $subject->getCurrency();
        $targetCurrency = $shippingMethod->getCurrency()->getCode();
        $grossAmount    = $this->currencyConverter->convert($subject->getGrossPrice(), $baseCurrency, $targetCurrency);

        return $this->filterRanges($ranges, $grossAmount);
    }

    public function getAlias() : string
    {
        return 'price_table';
    }

    private function filterRanges(Collection $ranges, float $grossAmount) : Collection
    {
        return $ranges->filter(function (ShippingMethodCostInterface $cost) use ($grossAmount) {
            return ($cost->getRangeFrom() <= $grossAmount && $cost->getRangeTo() >= $grossAmount);
        });
    }
}
