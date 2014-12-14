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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\Conditions;

/**
 * Interface ConditionInterface
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ConditionInterface
{
    /**
     * Returns Doctrine expression for field
     *
     * @return mixed
     */
    public function getExpression();
}