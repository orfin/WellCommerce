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

namespace WellCommerce\Plugin\ShippingMethod\Calculator;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\Form\Conditions\Equals;
use WellCommerce\Core\Component\Form\Dependency;
use WellCommerce\Core\Component\Form\Option;
use WellCommerce\Core\Event\FormEvent;

/**
 * Class AbstractShippingMethodCalculator
 *
 * @package WellCommerce\Plugin\ShippingMethod\Calculator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractShippingMethodCalculator extends AbstractComponent
{
    /**
     * @var string Shipping calculator alias
     */
    public $alias;

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormEvent $event)
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

        $this->addMethodConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function getBoxTypeOption()
    {
        return new Option($this->alias, $this->getName());
    }
} 