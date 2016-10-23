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
 * Class AbstractCondition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>\
 */
abstract class AbstractCondition implements ConditionInterface
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $operator;

    /**
     * Constructor
     *
     * @param $field
     * @param $value
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function getOperator() : string
    {
        return $this->operator;
    }
    
    public function isRangedOperator() : bool
    {
        return false;
    }
    
    public function getIdentifier() : string
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }
}
