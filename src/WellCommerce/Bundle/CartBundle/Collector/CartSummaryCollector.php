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

namespace WellCommerce\Bundle\CartBundle\Collector;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;

/**
 * Class CartSummaryCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartSummaryCollector implements CartSummaryCollectorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface $helper
     */
    public function __construct(CurrencyHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(CartInterface $cart)
    {
        $totals          = $cart->getTotals();
        $totalGrossPrice = $totals->getGrossPrice();
        $shippingCost    = $this->collectShippingCost($cart->getShippingMethodCost());

        return round($totalGrossPrice + $shippingCost, 2);
    }

    protected function collectShippingCost(ShippingMethodCostInterface $shippingMethodCost = null)
    {
        if (null !== $shippingMethodCost) {
            $cost         = $shippingMethodCost->getCost();
            $baseCurrency = $cost->getCurrency();
            $grossAmount  = $cost->getGrossAmount();

            return $this->helper->convert($grossAmount, $baseCurrency);
        }

        return 0;
    }
}
