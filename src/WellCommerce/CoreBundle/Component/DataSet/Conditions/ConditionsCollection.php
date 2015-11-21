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

namespace WellCommerce\CoreBundle\Component\DataSet\Conditions;

use WellCommerce\CoreBundle\Component\Collection\ArrayCollection;

/**
 * Class ConditionsCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionsCollection extends ArrayCollection
{
    /**
     * @param ConditionInterface $condition
     */
    public function add(ConditionInterface $condition)
    {
        $this->items[] = $condition;
    }

    /**
     * @return ConditionInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
