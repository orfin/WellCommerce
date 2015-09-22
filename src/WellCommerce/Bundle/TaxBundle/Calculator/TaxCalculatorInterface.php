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

namespace WellCommerce\Bundle\TaxBundle\Calculator;

/**
 * Interface TaxCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TaxCalculatorInterface
{
    /**
     * @return int|float
     */
    public function getNetPrice();

    /**
     * @return int|float
     */
    public function getTaxRate();

    /**
     * @return int|float
     */
    public function getTaxAmount();

    /**
     * @return int|float
     */
    public function getGrossPrice();
}
