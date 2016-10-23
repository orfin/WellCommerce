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

namespace WellCommerce\Component\DataSet\Conditions;

/**
 * Interface ConditionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ConditionInterface
{
    /**
     * Returns operator for expression
     *
     * @return string
     */
    public function getOperator() : string;

    /**
     * Returns field identifier
     *
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * Returns field value
     *
     * @return string|array
     */
    public function getValue();
    
    /**
     * @return bool
     */
    public function isRangedOperator() : bool;
}
