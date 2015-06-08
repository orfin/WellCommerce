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

use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;

/**
 * Class AbstractShippingMethodCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    protected $alias = null;

    /**
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * Constructor
     *
     * @param CartProviderInterface $cartProvider
     */
    public function __construct(CartProviderInterface $cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getName();

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {
        return 0;
    }
}
