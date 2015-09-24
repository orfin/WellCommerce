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

use WellCommerce\Bundle\CartBundle\Collector\CartTotalsCollectorInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class AbstractShippingMethodCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShippingMethodCalculator
{
    /**
     * @var null
     */
    protected $alias = null;

    /**
     * @var CartTotalsCollectorInterface
     */
    protected $cartTotalsCollector;

    /**
     * Constructor
     *
     * @param CartTotalsCollectorInterface $cartTotalsCollector
     */
    public function __construct(CartTotalsCollectorInterface $cartTotalsCollector)
    {
        $this->cartTotalsCollector = $cartTotalsCollector;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getName();

    /**
     * {@inheritdoc}
     */
    abstract public function getAlias();
}
