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

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ConditionsCollection
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionsCollection extends AbstractCollection
{
    /**
     * @param ConditionInterface $condition
     */
    public function add(ConditionInterface $condition)
    {
        $this->items[] = $condition;
    }

    public function all()
    {
        $conditions = [];

        /**
         * @var $item ConditionInterface
         */
        foreach ($this->items as $item) {
            $conditions[] = $item->getExpression();
        }

        return $conditions;
    }
}