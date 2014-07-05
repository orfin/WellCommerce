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

namespace WellCommerce\Plugin\ShippingMethod\Calculator;

/**
 * Class ItemQuantityCalculator
 *
 * @package WellCommerce\Plugin\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ItemQuantityCalculator extends AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->trans('Item quantity');
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function addMethodConfiguration(){

    }
} 