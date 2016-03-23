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

namespace WellCommerce\Component\DataSet\Conditions;

/**
 * Class ConditionsResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionsResolver
{
    /**
     * Adds additional conditions to request
     *
     * @param array                $params
     * @param ConditionsCollection $conditions
     *
     * @return ConditionsCollection
     */
    public function resolveConditions($params, ConditionsCollection $conditions)
    {
        if (is_array($params)) {
            foreach ($params as $where) {
                list($column, $operator, $value) = $this->parseParam($where);

                $factory   = new ConditionFactory($column, $value);
                $condition = $factory->createCondition($operator);
                $conditions->add($condition);
            }
        }
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
