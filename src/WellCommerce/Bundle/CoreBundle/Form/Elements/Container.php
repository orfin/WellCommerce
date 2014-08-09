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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;
use WellCommerce\Bundle\CoreBundle\Form\Node;

/**
 * Class Container
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>s
 */
abstract class Container extends Node
{
    protected $children;
    protected $tabsOffset;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->children   = [];
        $this->tabsOffset = '';
    }

    /**
     * Adds child element to node
     *
     * @param $child
     *
     * @return mixed
     */
    public function addChild($child)
    {
        $this->children[] = $child;
        $child->form      = $this->form;
        $child->parent    = $this;
        $childName        = $child->getName();
        if (isset($this->form->fields[$childName])) {
            if (is_array($this->form->fields[$childName])) {
                $this->form->fields[$childName][] = $child;
            } else {
                $this->form->fields[$childName] = Array(
                    $this->form->fields[$childName],
                    $child
                );
            }
        } else {
            $this->form->fields[$childName] = $child;
        }

        return $child;
    }

    final public function addChildren($children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    public function addRule($rule)
    {
        foreach ($this->children as $child) {
            $child->addRule($rule);
        }
    }

    public function clearRules()
    {
        foreach ($this->children as $child) {
            $child->clearRules();
        }
    }

    public function addFilter($filter)
    {
        foreach ($this->children as $child) {
            $child->addFilter($filter);
        }
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \LogicException('Filter must implement FilterInterface');
            }
            $this->addFilter($filter);
        }
    }

    public function clearFilters()
    {
        foreach ($this->children as $child) {
            $child->clearFilters();
        }
    }

    public function populate($value)
    {
        if (isset($value) && is_array($value) && $this->isIterated($value)) {
            foreach ($this->children as $child) {
                $valueArray = [];
                if (isset($value) && is_array($value)) {
                    foreach ($value as $i => $repetition) {
                        $name = $child->getName();
                        if (!empty($name)) {
                            if (isset($repetition[$name])) {
                                $valueArray[$i] = $repetition[$name];
                            } else {
                                $valueArray[$i] = '';
                            }
                        }
                    }
                }
                $child->populate($valueArray);
            }
        } else { // simple value
            foreach ($this->children as $child) {
                $name = $child->getName();
                if (empty($name)) {
                    continue;
                }
                if (isset($value[$name])) {
                    $child->populate($value[$name]);
                } elseif ($this->form->_populatingWholeForm) {
                    $child->populate(null);
                }
            }
        }
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getChild($name)
    {
        foreach ($this->form->fields as $child) {
            if (method_exists($child, 'getName') && $name === $child->getName()) {
                return $child;
            }
        }
    }

    public function getFields()
    {
        return $this->form->fields;
    }

    public function renderChildren()
    {
        $render = [];
        foreach ($this->children as $child) {
            $render[] = $child->render($this->_renderMode, $this->_tabs . $this->tabsOffset);
        }

        return implode(',', $render);
    }

    public function isValid($values = [])
    {
        $result = true;
        foreach ($this->children as $child) {
            if (!$child->isValid()) {
                $result = false;
            }
        }

        return $result;
    }

    protected function getValues()
    {
        $values = [];
        foreach ($this->children as $child) {
            if ($child instanceof Container) {
                $values[$child->getName()] = $child->getValues();
            } elseif ($child instanceof Field) {
                $values[$child->getName()] = $child->getValue();
            }
        }

        return $values;
    }
}
