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

namespace WellCommerce\Core\Layout\Box;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\Form\Conditions\Equals;
use WellCommerce\Core\Component\Form\Dependency;
use WellCommerce\Core\Component\Form\Option;
use WellCommerce\Core\Event\FormEvent;

/**
 * Class LayoutBoxConfigurator
 *
 * @package WellCommerce\Core\Layout\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class LayoutBoxConfigurator extends AbstractComponent implements LayoutBoxConfiguratorInterface
{
    protected $builder;
    protected $form;
    protected $typeSelect;
    protected $fieldset;

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        // available on all layout pages
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormEvent $event)
    {
        $this->builder    = $event->getFormBuilder();
        $this->form       = $this->builder->getForm();
        $this->typeSelect = $this->form->getChild('required_data')->getChild('type');

        $this->typeSelect->addOption(new Option($this->type, sprintf('%s (%s)', $this->name, $this->type)));

        $this->fieldset = $this->form->addChild($this->builder->addFieldset([
            'name'         => $this->type,
            'label'        => $this->trans('Box settings'),
            'dependencies' => [
                $this->builder->addDependency(Dependency::SHOW, $this->typeSelect, new Equals($this->type), null)
            ]
        ]));

        $this->addBoxConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function addBoxConfiguration()
    {
        return false;
    }
}