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

/**
 * Class AbstractLayoutBoxConfigurator
 *
 * @package WellCommerce\Bundle\LayoutBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractLayoutBoxConfigurator extends AbstractContainer
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
    protected function getFieldset(FormBuilderInterface $builder)
    {
        $form          = $builder->getForm();
        $boxTypeSelect = $form->getElement('boxType');
        $boxTypeSelect->addOption($this->type, $this->type);

        $fieldset = $form->addChild($builder->getElement('fieldset', [
            'name'         => $this->getType(),
            'label'        => $this->trans('Box settings'),
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
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }
}
