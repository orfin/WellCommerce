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

use WellCommerce\Bundle\CoreBundle\DataSet\Conditions\ConditionsCollection;

/**
 * Class ConditionsResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionsResolver
{
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
            return $this->createConditionsCollection($params);
        }

        return;
    }

    /**
     * Creates conditions collection
     *
     * @param array $params
     *
     * @return ConditionsCollection
     */
    private function createConditionsCollection(array $params)
    {
        $conditions = new ConditionsCollection();

        foreach ($params as $where) {
            list($column, $operator, $value) = $this->parseParam($where);

            $factory   = new ConditionFactory($column, $value);
            $condition = $factory->createCondition($operator);
            $conditions->add($condition);
        }

        return $conditions;
    }

    /**
     * Parses "where" parameters
     *
     * @param array $param
     *
     * @return array
     */
    private function parseParam(array $param)
    {
        $column   = $param['column'];
        $operator = $param['operator'];
        $value    = isset($param['value']) ? $param['value'] : null;

        return [
            $column,
            $operator,
            $value,
        ];
    }
}
