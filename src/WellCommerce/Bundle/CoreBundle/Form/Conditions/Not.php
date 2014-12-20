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

namespace WellCommerce\Bundle\CoreBundle\Form\Conditions;

/**
 * Class Not
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Not extends AbstractCondition implements ConditionInterface
{
    /**
     * {@inheritdoc}
     */
    public function evaluate($value)
    {
        if ($this->_argument instanceof ConditionInterface) {
            return !$this->_argument->evaluate($value);
        }

        return false;
    }

}
