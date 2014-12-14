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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\Conditions;

use Doctrine\Common\Collections\Criteria;

/**
 * Class AbstractCondition
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>\
 */
abstract class AbstractCondition
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
     * @var \Doctrine\Common\Collections\ExpressionBuilder
     */
    protected $expression;

    /**
     * @var string
     */
    protected $operator = 'eq';

    /**
     * Constructor
     *
     * @param $field
     * @param $value
     */
    public function __construct($field, $value)
    {
        $this->field      = $field;
        $this->value      = $value;
        $this->expression = Criteria::expr();
    }

    public function getExpression()
    {
        return $this->expression->{$this->operator}($this->field, $this->value);
    }
}