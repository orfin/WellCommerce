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

namespace WellCommerce\Bundle\CatalogBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Class ProducerManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerManager extends AbstractFrontManager
{
    /**
     * Returns a collection of dynamic conditions
     *
     * @return ConditionsCollection
     */
    public function getCurrentProducerConditions()
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('producerId', $this->getProducerContext()->getCurrentProducerIdentifier()));

        return $conditions;
    }
}
