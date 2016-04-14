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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\ShippingBundle\Adapter\ShippingCalculatorAdapterCollection;
use WellCommerce\Bundle\ShippingBundle\Adapter\ShippingCalculatorAdapterInterface;

/**
 * Class AbstractShippingMethodCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShippingMethodCalculator extends AbstractContainerAware implements ShippingMethodCalculatorInterface
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @var ShippingCalculatorAdapterCollection
     */
    protected $adapters;

    /**
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * AbstractShippingMethodCalculator constructor.
     *
     * @param string                              $alias
     * @param ShippingCalculatorAdapterCollection $adapters
     */
    public function __construct(string $alias, ShippingCalculatorAdapterCollection $adapters)
    {
        $this->alias    = $alias;
        $this->adapters = $adapters;
    }

    public function getAlias() : string
    {
        return $this->alias;
    }

    protected function getAdapter($resource) : ShippingCalculatorAdapterInterface
    {
    }
}
