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

namespace WellCommerce\CatalogBundle\Manager\Front;

use WellCommerce\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\CoreBundle\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\CoreBundle\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class CategoryManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryManager extends AbstractFrontManager
{
    /**
     * Returns a collection of dynamic conditions
     *
     * @return ConditionsCollection
     */
    public function getCurrentCategoryConditions()
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('category', $this->getCategoryContext()->getCurrentCategoryIdentifier()));

        return $conditions;
    }
}
