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

namespace WellCommerce\ShippingMethod\Calculator;

use WellCommerce\Core\Component\Form\FormBuilderInterface;

/**
 * Interface ShippingMethodCalculatorInterface
 *
 * @package WellCommerce\ShippingMethod\Calculator
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
     * Adds fields to costs definition tab
     *
     * @return mixed
     */
    public function addConfigurationFields();
}