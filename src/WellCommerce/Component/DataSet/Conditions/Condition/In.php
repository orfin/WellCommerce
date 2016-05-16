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

/**
 * Class In
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class In extends AbstractCondition
{
    protected $operator = 'in';

    public function getValue()
    {
        return !is_array($this->value) ? (array)$this->value : $this->value;
    }
}
