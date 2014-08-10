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

namespace WellCommerce\Bundle\CoreBundle\Layout\Box;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\Conditions\Equals;
use WellCommerce\Bundle\CoreBundle\Form\Dependency;
use WellCommerce\Bundle\CoreBundle\Form\Option;
use WellCommerce\Bundle\CoreBundle\Event\FormEvent;

/**
 * Class LayoutBoxConfigurator
 *
 * @package WellCommerce\Bundle\CoreBundle\Layout\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class LayoutBoxConfigurator extends AbstractContainer implements LayoutBoxConfiguratorInterface
{
    /**
     * @var string Box type
     */
    public $type;

    /**
     * @var string Controller service name
     */
    public $controller;

    /**
     * @var string Class name
     */
    public $class;

    /**
     * @var object FormBuilder instance
     */
    protected $builder;

    /**
     * @var object FormInterface
     */
    protected $form;

    /**
     * @var object Select form element for choosing box type
     */
    protected $typeSelect;

    /**
     * @var object Default settings fieldset element
     */
    protected $fieldset;

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
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

        $this->typeSelect->addOption($this->getBoxTypeOption());

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

    /**
     * Adds new option to select for current box configurator
     *
     * @return Option An option element
     */
    private function getBoxTypeOption()
    {
        return new Option($this->type, sprintf('%s (%s)', $this->name, $this->type));
    }
}