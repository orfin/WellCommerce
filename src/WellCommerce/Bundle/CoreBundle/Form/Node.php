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

namespace WellCommerce\Bundle\CoreBundle\Form;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Form\Resolver\ElementResolverInterface;

/**
 * Class Node
 *
 * @package WellCommerce\Bundle\CoreBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class Node extends ContainerAware
{
    protected $form = null;
    protected $parent = null;
    protected $_id;
    protected $attributes;
    protected $_renderMode = 'JS';
    protected $_tabs = '';
    protected $_jsNodeName;
    protected $_xajaxMethods = [];
    protected static $_nextId = 0;
    protected $optionsResolver;
    protected $elementResolver;
    protected $options;

    public function __construct()
    {
        $this->optionsResolver = new OptionsResolver();
        $this->_id             = self::$_nextId++;
        $class                 = explode('\\', get_class($this));
        $this->_jsNodeName     = 'GForm' . end($class);
    }

    public function setOptions(array $options = [])
    {
        $this->configureAttributes($this->optionsResolver);
        $this->attributes = $this->optionsResolver->resolve($options);

        return $this;
    }

    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name'
        ]);
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
                $this->form->fields[$childName] = [
                    $this->form->fields[$childName],
                    $child
                ];
            }
        } else {
            $this->form->fields[$childName] = $child;
        }

        return $child;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function render($mode = 'JS', $tabs = '')
    {
        $this->_tabs       = $tabs;
        $this->_renderMode = $mode;
        $renderFunction    = 'render' . $mode;
        $lines             = explode(PHP_EOL, $this->$renderFunction());
        foreach ($lines as &$line) {
            $line = $this->_tabs . $line;
        }

        return implode("\n", $lines);
    }

    public function clearRules()
    {
        $this->attributes['rules'] = [];
    }

    public function addRule($type, $options = [])
    {
        $rule = $this->container->get('form.resolver.rule')->get($type, $options);

        $this->attributes['rules'][] = $rule;
    }

    public function addFilter($type, $options = [])
    {
        $filter = $this->container->get('form.resolver.filter')->get($type, $options);

        $this->attributes['filters'][] = $filter;
    }

    public function addDependency($type, $options = [])
    {
        $dependency = $this->container->get('form.resolver.dependency')->get($type, $options);

        $this->attributes['dependencies'][] = $dependency;
    }

    protected function filter($values)
    {
        if (!isset($this->attributes['filters']) || !is_array($this->attributes['filters'])) {
            return $values;
        }
        if (is_array($values)) {
            foreach ($values as &$value) {
                foreach ($this->attributes['filters'] as $filter) {
                    $value = $filter->filter($value);
                }
            }
        } else {
            foreach ($this->attributes['filters'] as $filter) {
                $values = $filter->filter($values);
            }
        }

        return $values;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    public function getPropertyPath()
    {
        return $this->attributes['property_path'];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    protected function harvestValues($node, $levels)
    {
        $value = $node->getValue();
        foreach ($levels as $level) {
            if (isset($value[$level])) {
                $value = $value[$level];
            } else {
                return '';
            }
        }

        return $value;
    }

    protected function harvestErrors($node, $levels)
    {
        if (!isset($node->attributes['error'])) {
            return '';
        }
        $value = $node->attributes['error'];
        foreach ($levels as $level) {
            if (isset($value[$level])) {
                $value = $value[$level];
            } else {
                return '';
            }
        }

        return $value;
    }

    protected function harvest($action, $levelsCount = 0, $levels = [])
    {
        if (isset($this->children)) {
            $array = [];
            foreach ($this->children as $child) {
                $name = $child->getName();
                if (empty($name)) {
                    continue;
                }
                if ($this instanceof Elements\FieldsetRepeatable) {
                    $repetitions = $child->harvestRepetitions($levelsCount);
                    foreach ($repetitions as $repetition) {
                        $levelsCopy                = $levels + [$repetition];
                        $array[$repetition][$name] = $child->harvest($action, $levelsCount + 1, $levelsCopy);
                    }
                } else {
                    $array[$name] = $child->harvest($action, $levelsCount, $levels);
                }
            }

            return $array;
        } else {
            if (is_array($action)) {
                return call_user_func($action, $this, $levels);
            }

            return $action($this, $levels);
        }
    }

    protected function harvestRepetitions($level = 0)
    {
        if (isset($this->children)) {
            $array = [];
            foreach ($this->children as $child) {
                array_push($array, $child->harvestRepetitions($level));
            }

            return array_unique($array);
        } else {
            $value       = $this->getValue();
            $repetitions = $this->extractRepetitions($value, $level);

            return array_unique($repetitions);
        }
    }

    protected function extractRepetitions($array, $targetLevel, $level = 0)
    {
        if ($targetLevel >= $level) {
            if (is_array($array)) {
                return array_keys($array);
            }

            return [];
        }
        $repetitions = [];
        foreach ($array as $value) {
            array_push($repetitions, $this->extractRepetitions($value, $targetLevel, $level + 1));
        }

        return $repetitions;
    }

    protected function formatAttributesJs($attributes)
    {
        $attributes       = array_merge($attributes, $this->prepareAutoAttributesJs());
        $attributesString = PHP_EOL;
        foreach ($attributes as $attribute) {
            if (!empty($attribute)) {
                $attributesString .= $this->_tabs . $attribute . ",\n";
            }
        }

        return substr($attributesString, 0, -2) . "\n";
    }

    protected function formatAttributeJs($attributeName, $name = null, $type = Elements\ElementInterface::TYPE_STRING)
    {
        if ($name == null) {
            if (!isset($this->attributes[$attributeName])) {
                if ($type == Elements\ElementInterface::TYPE_FUNCTION) {
                    return 'null';
                } elseif ($type == Elements\ElementInterface::TYPE_NUMBER) {
                    return '0';
                } elseif ($type == Elements\ElementInterface::TYPE_ARRAY) {
                    return '[]';
                } elseif ($type == Elements\ElementInterface::TYPE_OBJECT) {
                    return '{}';
                } elseif ($type == Elements\ElementInterface::TYPE_BOOLEAN) {
                    return 'false';
                }

                return '\'\'';
            }
            if ($type == Elements\ElementInterface::TYPE_FUNCTION) {
                return $this->attributes[$attributeName];
            } elseif ($type == Elements\ElementInterface::TYPE_NUMBER) {
                return $this->attributes[$attributeName];
            } elseif ($type == Elements\ElementInterface::TYPE_ARRAY) {
                return json_encode($this->attributes[$attributeName]);
            } elseif ($type == Elements\ElementInterface::TYPE_OBJECT) {
                return json_encode($this->attributes[$attributeName]);
            } elseif ($type == Elements\ElementInterface::TYPE_BOOLEAN) {
                return $this->attributes[$attributeName] ? 'true' : 'false';
            }

            return str_replace(Array(
                "\r\n",
                "\n"
            ), '\n', '\'' . addslashes($this->attributes[$attributeName]) . '\'');
        }
        if (!isset($this->attributes[$attributeName])) {
            return '';
        }
        $value = $this->attributes[$attributeName];
        if ($type == Elements\ElementInterface::TYPE_ARRAY) {
            return $name . ': ' . json_encode($value);
        } elseif ($type == Elements\ElementInterface::TYPE_OBJECT) {
            return $name . ': ' . json_encode($value);
        } elseif (is_array($value)) {
            foreach ($value as &$valuePart) {
                if ($type == Elements\ElementInterface::TYPE_FUNCTION) {
                    $valuePart = '' . ($valuePart) . '';
                } elseif ($type == Elements\ElementInterface::TYPE_NUMBER) {
                    $valuePart = '' . ($valuePart) . '';
                } else {
                    $valuePart = '\'' . addslashes($valuePart) . '\'';
                }
            }

            return str_replace("\n", '\n', $name . ': [' . implode(', ', $value) . ']');
        } else {
            if ($type == Elements\ElementInterface::TYPE_FUNCTION) {
                return $name . ': ' . ($value) . '';
            } elseif ($type == Elements\ElementInterface::TYPE_NUMBER) {
                return $name . ': ' . ($value) . '';
            } elseif ($type == Elements\ElementInterface::TYPE_BOOLEAN) {
                return $name . ': ' . ($value ? 'true' : 'false') . '';
            } else {
                return str_replace(Array(
                    "\r\n",
                    "\n"
                ), '\n', $name . ': \'' . addslashes($value) . '\'');
            }
        }
    }

    protected function formatRepeatableJs()
    {
        if ((isset($this->attributes['repeat_min']) && ($this->attributes['repeat_min'] != 1)) || (isset($this->attributes['repeat_max']) && ($this->attributes['repeat_max'] != 1))) {
            $min
                = (isset($this->attributes['repeat_min']) && is_numeric($this->attributes['repeat_min'])) ? $this->attributes['repeat_min'] : 1;
            $max
                = (isset($this->attributes['repeat_max']) && is_numeric($this->attributes['repeat_max'])) ? $this->attributes['repeat_max'] : 1;
            if (isset($this->attributes['repeat_max']) && ($this->attributes['repeat_max'] == Elements\ElementInterface::INFINITE)) {
                $max = 'GForm.INFINITE';
            }

            return "oRepeat: {iMin: {$min}, iMax: {$max}}";
        }

        return '';
    }

    protected function formatDependencyJs()
    {
        $dependencies = [];
        if (isset($this->attributes['dependencies']) && is_array($this->attributes['dependencies'])) {
            foreach ($this->attributes['dependencies'] as $dependency) {
                $dependencies[] = $dependency->renderJs();
            }
        }
        if (count($dependencies)) {
            return 'agDependencies: [' . implode(', ', $dependencies) . ']';
        }

        return '';
    }

    protected function formatFactorJs($factor, $name)
    {
        return "{$name}: {$this->attributes[$factor]->render()}";
    }

    public function renderJs()
    {
        $render = "
			{fType: {$this->_jsNodeName},{$this->formatAttributesJs($this->prepareAttributesJs())}}
		";

        return $render;
    }

    protected function prepareAttributesJs()
    {
        return [];
    }

    public function renderStatic()
    {
    }

    public function isValid()
    {
        return true;
    }

    protected function isIterated($array)
    {
        if (is_numeric(key($array)) || substr(key($array), 0, 4) == 'new-') {
            return true;
        }

        return false;
    }

    public function populate($value)
    {
    }

    protected function prepareAutoAttributesJs()
    {
        $attributes = [];
        $attributes = array_merge($attributes, $this->_xajaxMethods);

        return $attributes;
    }

    protected function registerXajaxMethod($name, $callback)
    {
        $jsName                  = $name . '_' . $this->_id;
        $this->attributes[$name] = 'xajax_' . $jsName;
        App::getRegistry()->xajaxInterface->registerFunction(array(
            $jsName,
            $callback[0],
            $callback[1]
        ));
        $this->_xajaxMethods[] = $this->formatAttributeJs($name, $name, FE::TYPE_FUNCTION);
    }

    public function __get($attributeName)
    {
        return isset($this->attributes[$attributeName]) ? $this->attributes[$attributeName] : null;
    }
}
