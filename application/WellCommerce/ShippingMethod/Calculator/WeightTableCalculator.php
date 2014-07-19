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

/**
 * Class WeightTableCalculator
 *
 * @package WellCommerce\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WeightTableCalculator extends AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->trans('Weight table');
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
    public function addConfigurationFields(){

    }
} 