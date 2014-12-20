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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Conditions;

use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\Eq;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\Gte;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\In;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\Like;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\Lte;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\Condition\Neq;
use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\ConditionsCollection;

/**
 * Class ConditionsResolver
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionsResolver
{
    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * Constructor
     *
     * @param ColumnCollection $collection
     */
    public function __construct(ColumnCollection $collection)
    {
        $this->columns = $collection;
    }

    /**
     * Resolves "where" params and creates conditions collection
     *
     * @param array $params
     *
     * @return null|ConditionsCollection
     */
    public function resolve($params)
    {
        if (is_array($params)) {
            $conditions = new ConditionsCollection();

            foreach ($params as $where) {
                $column     = $where['column'];
                $operator   = $where['operator'];
                $value      = isset($where['value']) ? $where['value'] : null;
                $expression = null;

                switch ($operator) {
                    case 'IN':
                        $conditions->add(new In($column, $value));
                        break;
                    case 'NE':
                        $conditions->add(new Neq($column, $value));
                        break;
                    case 'LE':
                        $conditions->add(new Lte($column, $value));
                        break;
                    case 'GE':
                        $conditions->add(new Gte($column, $value));
                        break;
                    case 'LIKE':
                        $conditions->add(new Like($column, $value));
                        break;
                    default:
                        $conditions->add(new Eq($column, $value));
                        break;
                }
            }

            return $conditions;
        }

        return null;
    }
}