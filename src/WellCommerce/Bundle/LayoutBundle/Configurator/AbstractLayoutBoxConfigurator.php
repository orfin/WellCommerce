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

namespace WellCommerce\Bundle\LayoutBundle\Configurator;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Conditions\Equals;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class AbstractLayoutBoxConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractLayoutBoxConfigurator extends AbstractContainer implements LayoutBoxConfiguratorInterface
{
    protected $type;
    protected $controllerService;

    /**
     * Constructor
     *
     * @param $type
     * @param $controllerService
     */
    public function __construct($type, $controllerService)
    {
        $this->type              = $type;
        $this->controllerService = $controllerService;
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerService()
    {
        return $this->controllerService;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFieldset(FormBuilderInterface $builder, FormInterface $form)
    {
        $boxTypeSelect = $this->getBoxTypeSelect($form);
        $boxTypeSelect->addOptionToSelect($this->type, $this->type);

        $fieldset = $form->addChild($builder->getElement('nested_fieldset', [
            'name'         => $this->getType(),
            'label'        => $this->trans('layout_box.label.settings'),
            'dependencies' => [
                $builder->getDependency('show', [
                    'field'     => $boxTypeSelect,
                    'condition' => new Equals($this->type),
                    'form'      => $form
                ]),
            ]
        ]));

        return $fieldset;
    }

    /**
     * @param FormInterface $form
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\Optioned\Select
     */
    protected function getBoxTypeSelect(FormInterface $form)
    {
        return $form->getChildren()->get('required_data')->getChildren()->get('boxType');
    }
}
