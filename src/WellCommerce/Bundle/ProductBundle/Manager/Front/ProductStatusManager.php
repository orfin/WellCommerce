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

namespace WellCommerce\Bundle\ProductBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Class ProductStatusManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusManager extends AbstractFrontManager
{
    /**
     * Return additional conditions for QueryBuilder
     *
     * @return ConditionsCollection
     */
    public function getStatusConditions($status = null)
    {
        if (null === $status && null !== $this->getProductStatusProvider()->getCurrentProductStatus()) {
            $status = $this->getProductStatusProvider()->getCurrentProductStatus()->getId();
        }

        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('status', (int)$status));

        return $conditions;
    }
}
