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

namespace WellCommerce\Component\DataSet\Conditions\Condition;

use WellCommerce\Component\DataSet\Conditions\AbstractCondition;
use WellCommerce\Component\DataSet\Conditions\ConditionInterface;

/**
 * Class In
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class In extends AbstractCondition implements ConditionInterface
{
    protected $operator = 'in';

    public function getValue()
    {
        return !is_array($this->value) ? (array) $this->value : $this->value;
    }
}
