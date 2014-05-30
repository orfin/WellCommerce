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

namespace WellCommerce\Core\Component\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Form
 *
 * @package WellCommerce\Core\Component\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Form extends Container
{
    const FORMAT_GROUPED  = 0;
    const FORMAT_FLAT     = 1;
    const TABS_VERTICAL   = 0;
    const TABS_HORIZONTAL = 1;

    public $fields = [];
    public $_values = [];
    public $_flags = [];
    public $_populatingWholeForm = false;

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
        $this->form = $this;
    }

    /**
     * Configures Form attributes
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name'
        ]);

        $resolver->setOptional([
            'class',
            'action',
            'method',
            'tabs',
        ]);

        $resolver->setDefaults([
            'action' => '',
            'class'  => '',
            'method' => 'POST',
            'tabs'   => self::TABS_VERTICAL,
        ]);

        $resolver->setAllowedTypes([
            'class'  => 'string',
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer'
        ]);

    }

    /**
     * Returns flattened $_POST data
     *
     * @return array|mixed
     */
    public function getSubmitValuesFlat()
    {
        return $this->getValues(self::FORMAT_FLAT);
    }

    /**
     * Returns grouped $_POST data
     *
     * @return array|mixed
     */
    public function getSubmitValuesGrouped()
    {
        return $this->getValues(self::FORMAT_GROUPED);
    }

    /**
     * Returns value for given form element
     *
     * @param $element
     *
     * @return mixed
     */
    public function getElementValue($element)
    {
        return $this->getValue($element);
    }

    public function convertData()
    {
        $values = [];
        foreach ($this->fields as $field) {
            if ($field instanceof Field) {
                $values = array_merge_recursive($values, Array(
                    $field->getName() => $field->getValue()
                ));
            }
        }

        print_r($values);
        die();
    }

    public function getValues($flags = 0)
    {
        if ($flags & self::FORMAT_FLAT) {
            $values = [];
            foreach ($this->fields as $field) {
                if (is_object($field)) {
                    if ($field instanceof Field) {
                        $values = array_merge_recursive($values, Array(
                            $field->getName() => $field->getValue()
                        ));
                    }
                } else {
                    if ($field instanceof Field) {
                        $values = array_merge_recursive($values, Array(
                            $field->getName() => $field->getValue()
                        ));
                    }
                }
            }

            return $values;
        } else {
            return $this->harvest(Array(
                $this,
                'harvestValues'
            ));
        }

        return [];
    }

    /**
     * Returns an array containing all form errors
     *
     * @return array|mixed
     */
    public function getErrors()
    {
        return $this->harvest([$this, 'harvestErrors']);
    }

    public function getValue($element)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() == $element) {
                return $field->getValue();
            }
        }
    }

    public function GetFlags()
    {
        return $this->_flags;
    }

    public function populate($value, $flags = 0)
    {
        if ($flags & self::FORMAT_FLAT) {
            return;
        } else {
            $this->_values = $this->_values + $value;
        }
        $this->_populatingWholeForm = true;
        parent::populate($value);
        $this->_populatingWholeForm = false;
    }

    public function isValid($values = [])
    {
        $values = $this->getSubmittedData();

        if (!isset($values[$this->attributes['name'] . '_submitted']) || !$values[$this->attributes['name'] . '_submitted']) {
            return false;
        }
        $this->populate($values);

        return parent::isValid();
    }

    public function getSubmittedData()
    {
        return $_POST;
    }

    public function isAction($actionName)
    {
        $actionName = '_Action_' . $actionName;

        return (isset($_POST[$actionName]) && ($_POST[$actionName] == '1'));
    }
}
