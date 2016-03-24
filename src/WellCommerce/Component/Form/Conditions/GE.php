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

namespace WellCommerce\Component\Form\Conditions;

/**
 * Class GE
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GE extends AbstractCondition
{
    /**
     * {@inheritdoc}
     */
    public function evaluate($value)
    {
        if ($this->_argument instanceof ConditionInterface) {
            return false;
        }

        return ($value >= $this->_argument);
    }
}
