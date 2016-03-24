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
namespace WellCommerce\Component\Form\Conditions;

/**
 * Class Condition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractCondition implements ConditionInterface
{
    protected $_jsConditionName;

    protected $_argument;

    /**
     * Constructor
     *
     * @param $argument
     */
    public function __construct($argument)
    {
        $class                  = explode('\\', get_class($this));
        $this->_jsConditionName = 'GFormCondition.' . strtoupper(end($class));
        $this->_argument        = $argument;
    }

    /**
     * {@inheritdoc}
     */
    public function renderJs()
    {
        if ($this->_argument instanceof ConditionInterface) {
            return "new GFormCondition({$this->_jsConditionName}, {$this->_argument->renderJs()})";
        }
        if (is_array($this->_argument) && isset($this->_argument[0]) && ($this->_argument[0] instanceof ConditionInterface)) {
            $parts = [];
            foreach ($this->_argument as $part) {
                $parts[] = $part->renderJs();
            }
            $argument = '[' . implode(', ', $parts) . ']';
        } else {
            $argument = json_encode($this->_argument);
        }

        return "new GFormCondition({$this->_jsConditionName}, {$argument})";
    }

    /**
     * Evaluates condition value
     *
     * @return bool
     */
    public function evaluate($value)
    {
        return !empty($value);
    }
}
