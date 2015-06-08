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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ShippingMethodCalculatorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodCalculatorCollection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function add(ShippingMethodCalculatorInterface $calculator)
    {
        if ($this->has($alias = $calculator->getAlias())) {
            throw new \InvalidArgumentException(sprintf(
                'Non unique alias "%s" for shipping method calculator',
                $alias
            ));
        }

        $this->items[$alias] = $calculator;
    }
}

