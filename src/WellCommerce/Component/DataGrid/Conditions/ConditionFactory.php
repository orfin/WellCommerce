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

namespace WellCommerce\Component\DataGrid\Conditions;

use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\Condition\Gte;
use WellCommerce\Component\DataSet\Conditions\Condition\In;
use WellCommerce\Component\DataSet\Conditions\Condition\Like;
use WellCommerce\Component\DataSet\Conditions\Condition\Lte;
use WellCommerce\Component\DataSet\Conditions\Condition\Neq;
use WellCommerce\Component\DataSet\Conditions\ConditionInterface;

/**
 * Class ConditionFactory
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ConditionFactory
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string $column
     * @param mixed  $value
     */
    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value  = $value;
    }

    public function createCondition(string $operator) : ConditionInterface
    {
        switch ($operator) {
            case 'IN':
                $condition = new In($this->column, $this->value);
                break;
            case 'NE':
                $condition = new Neq($this->column, $this->value);
                break;
            case 'LE':
                $condition = new Lte($this->column, $this->value);
                break;
            case 'GE':
                $condition = new Gte($this->column, $this->value);
                break;
            case 'LIKE':
                $condition = new Like($this->column, $this->value);
                break;
            default:
                $condition = new Eq($this->column, $this->value);
                break;
        }

        return $condition;
    }
}
