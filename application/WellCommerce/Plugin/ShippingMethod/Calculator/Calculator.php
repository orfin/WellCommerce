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

use WellCommerce\Core\Component\AbstractComponent;

class Calculator extends AbstractComponent implements CalculatorInterface
{
    protected $calculators;

    public function getName()
    {
        return false;
    }

    public function getRange()
    {
        return false;
    }

    public function calculate()
    {
        return false;
    }

    public function calculateProduct()
    {
        return false;
    }

    public function addCalculator($alias, CalculatorInterface $calculator)
    {
        $this->calculators[$alias] = $calculator;
    }

    public function getCalculatorsToSelect()
    {
        $select = [];
        foreach ($this->calculators as $alias => $calculator) {
            $select[$alias] = $calculator->getName();
        }

        return $select;

    }

} 