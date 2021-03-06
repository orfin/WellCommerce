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

namespace WellCommerce\Core\Form\Conditions;

use WellCommerce\Core\ConditionInterface;
use WellCommerce\Core\Form\Condition;

/**
 * Class Not
 *
 * @package WellCommerce\Core\Form\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Not extends Condition implements ConditionInterface
{

    public function evaluate($value)
    {
        if ($this->_argument instanceof Condition) {
            return !$this->_argument->evaluate($value);
        }

        return false;
    }

}
