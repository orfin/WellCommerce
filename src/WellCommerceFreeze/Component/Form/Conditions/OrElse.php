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
 * Class OrElse
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrElse extends AbstractCondition
{
    /**
     * {@inheritdoc}
     */
    public function evaluate($value)
    {
        if ($this->_argument instanceof ConditionInterface) {
            return $this->_argument->evaluate($value);
        }
        if (is_array($this->_argument)) {
            foreach ($this->_argument as $part) {
                if (!$part instanceof ConditionInterface) {
                    return false;
                }
                if ($part->evaluate($value)) {
                    return true;
                }
            }
        }

        return false;
    }
}
