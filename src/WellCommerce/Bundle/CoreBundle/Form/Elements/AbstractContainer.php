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

use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Class AbstractContainer
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractContainer extends AbstractNode
{
    protected $children   = [];
    protected $tabsOffset = '';

    public function addRule($type, $options = [])
    {
        foreach ($this->children as $child) {
            $child->addRule($type, $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter($type, $options = [])
    {
        foreach ($this->children as $child) {
            $child->addFilter($type, $options);
        }
    }

    public function setDefaults($values)
    {
        foreach ($this->children as $child) {
            $child->setDefaults($values);
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
        } else {
            // simple value
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

    public function getFields()
    {
        return $this->form->fields;
    }

    public function renderChildren()
    {
        $render = [];
        foreach ($this->children as $child) {
            $render[] = $child->render($this->renderMode, $this->tabs . $this->tabsOffset);
        }

        return implode(',', $render);
    }

    public function validate($resource)
    {
        $result = true;
        foreach ($this->children as $child) {
            if (!$child->validate($resource)) {
                $result = false;
            }
        }

        return $result;
    }

    protected function getValues()
    {
        $values = [];
        foreach ($this->children as $child) {
            if ($child instanceof AbstractContainer) {
                $values[$child->getName()] = $child->getValues();
            } elseif ($child instanceof AbstractField) {
                $values[$child->getName()] = $child->getValue();
            }
        }

        return $values;
    }

    public function getChild($name)
    {
        foreach ($this->form->fields as $child) {
            if ($child) {
                if (method_exists($child, 'getName') && $name === $child->getName()) {
                    return $child;
                }
            }
        }
    }

    public function getElement($path)
    {
        $accessor = $this->getPropertyAccessor();
        return $accessor->getValue($this->form->fields, sprintf('[%s]', $path));
    }
}
