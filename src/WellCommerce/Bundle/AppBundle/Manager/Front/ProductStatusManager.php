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

namespace WellCommerce\Bundle\AppBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

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
        if (null === $status) {
            $status = $this->getProductStatusContext()->getCurrentProductStatusIdentifier();
        }

        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('status', $status));

        return $conditions;
    }

    /**
     * Returns a collection of dynamic conditions
     *
     * @return ConditionsCollection
     */
    public function getShowcaseCategoryProducts($id, $status)
    {
        $conditions = $this->getStatusConditions($status);
        $conditions->add(new Eq('category', $id));

        return $this->get('product.dataset.front')->getResult('datagrid', [
            'limit'      => 10,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $conditions
        ]);
    }
}
