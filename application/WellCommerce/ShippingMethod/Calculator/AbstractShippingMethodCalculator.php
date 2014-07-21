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

namespace WellCommerce\ShippingMethod\Calculator;

use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\Form\Conditions\Equals;
use WellCommerce\Core\Form\Dependency;
use WellCommerce\Core\Form\Option;
use WellCommerce\Core\Event\FormEvent;

/**
 * Class AbstractShippingMethodCalculator
 *
 * @package WellCommerce\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractShippingMethodCalculator extends AbstractComponent
{
    /**
     * @var string Shipping calculator alias
     */
    public $alias;

    /**
     * @var \WellCommerce\Core\Form\Builder\FormBuilderInterface
     */
    public $builder;

    /**
     * @var \WellCommerce\Core\Form\FormInterface
     */
    public $form;

    /**
     * @var \WellCommerce\Core\Form\Elements\Select
     */
    public $typeSelect;

    /**
     * @var \WellCommerce\Core\Form\Elements\Fieldset
     */
    public $fieldset;

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFieldset(FormEvent $event)
    {
        $this->builder    = $event->getFormBuilder();
        $this->form       = $this->builder->getForm();
        $this->typeSelect = $this->form->getChild('required_data')->getChild('type');

        $this->typeSelect->addOption($this->getBoxTypeOption());

        $this->fieldset = $this->form->addChild($this->builder->addFieldset([
            'name'         => $this->alias,
            'label'        => $this->getName(),
            'dependencies' => [
                $this->builder->addDependency(Dependency::SHOW, $this->typeSelect, new Equals($this->alias), null)
            ]
        ]));

        $this->addConfigurationFields();
    }

    /**
     * {@inheritdoc}
     */
    public function getBoxTypeOption()
    {
        return new Option($this->alias, $this->getName());
    }
} 