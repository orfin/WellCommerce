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

namespace WellCommerce\Core\Component\Form\Conditions;

use WellCommerce\Core\ConditionInterface;
use WellCommerce\Core\Component\Form\Condition;

/**
 * Class OrElse
 *
 * @package WellCommerce\Core\Form\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrElse extends Condition implements ConditionInterface
{

    public function evaluate($value)
    {
        if ($this->_argument instanceof Condition) {
            return $this->_argument->evaluate($value);
        }
        if (is_array($this->_argument)) {
            foreach ($this->_argument as $part) {
                if (!$part instanceof Condition) {
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
