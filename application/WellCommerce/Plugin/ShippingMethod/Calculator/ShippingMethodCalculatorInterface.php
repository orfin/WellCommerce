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
 * Interface ShippingMethodCalculatorInterface
 *
 * @package WellCommerce\Plugin\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCalculatorInterface
{
    /**
     * Returns calculators name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Calculates shipping costs for given parameters
     *
     * @return mixed
     */
    public function calculate();

    /**
     * Adds fields to settings pane to allow cost editing for this calculator
     *
     * @return mixed
     */
    public function addMethodConfiguration();
}