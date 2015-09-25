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
use WellCommerce\Bundle\IntlBundle\Helper\CurrencyHelperInterface;

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
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * Constructor
     *
     * @param CartTotalsCollectorInterface $cartTotalsCollector
     * @param CurrencyHelperInterface      $currencyHelper
     */
    public function __construct(CartTotalsCollectorInterface $cartTotalsCollector, CurrencyHelperInterface $currencyHelper)
    {
        $this->cartTotalsCollector = $cartTotalsCollector;
        $this->currencyHelper      = $currencyHelper;
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
