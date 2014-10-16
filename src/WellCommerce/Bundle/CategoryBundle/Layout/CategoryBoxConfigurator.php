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

namespace WellCommerce\Bundle\CategoryBundle\Layout;

use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorInterface;
use WellCommerce\Bundle\LayoutBundle\Configurator\AbstractLayoutBoxConfigurator;

/**
 * Class CategoryBoxConfigurator
 *
 * @package WellCommerce\Bundle\CategoryBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxConfigurator extends AbstractLayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder, $defaults)
    {
        $fieldset = $this->getFieldset($builder);
        $accessor = $this->getPropertyAccessor();

        $fieldset->addChild($builder->getElement('tip', [
            'tip' => '<p>' . $this->trans('Choose categories which should be not visible in box.') . '</p>'
        ]));

        $fieldset->addChild($builder->getElement('tree', [
            'name'       => 'exclude',
            'label'      => $this->trans('category.parent'),
            'choosable'  => false,
            'selectable' => true,
            'sortable'   => false,
            'clickable'  => false,
            'items'      => $this->get('category.repository')->getTreeItems(),
            'default'    => $accessor->getValue($defaults, '[exclude]')
        ]));
    }
} 