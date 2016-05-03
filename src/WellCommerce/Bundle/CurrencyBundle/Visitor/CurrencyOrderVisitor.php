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

namespace WellCommerce\Bundle\CurrencyBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CurrencyBundle\Converter\CurrencyConverterInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;

/**
 * Class ShippingMethodCartVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CurrencyOrderVisitor implements OrderVisitorInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * CurrencyOrderVisitor constructor.
     *
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $currency     = $order->getCurrency();
        $currencyRate = $this->currencyConverter->getExchangeRate($currency);
        $order->setCurrencyRate($currencyRate);
    }
}
