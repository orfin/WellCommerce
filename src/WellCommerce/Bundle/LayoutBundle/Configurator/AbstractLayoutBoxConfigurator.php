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

use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Conditions\Equals;

/**
 * Class AbstractLayoutBoxConfigurator
 *
 * @package WellCommerce\Bundle\LayoutBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractLayoutBoxConfigurator extends AbstractContainer
{
    protected $type;
    protected $boxController;

    /**
     * Constructor
     *
     * @param                        $type
     * @param BoxControllerInterface $boxController
     */
    public function __construct($type, BoxControllerInterface $boxController)
    {
        $this->type          = $type;
        $this->boxController = $boxController;
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
    public function getBoxController()
    {
        return $this->boxController;
    }

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
                ])
            ]
        ]));

        return $fieldset;
    }
}