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

use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class ProductStatusBoxConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusBoxConfigurator extends AbstractLayoutBoxConfigurator
{
    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder, FormInterface $form, $defaults)
    {
        $fieldset = $this->getFieldset($builder, $form);

        $fieldset->addChild($builder->getElement('tip', [
            'tip' => $this->trans('layout_box.product_status.tip')
        ]));

        $statuses   = $this->get('product_status.dataset.admin')->getResult('select');
        $statusKeys = array_keys($statuses);

        $fieldset->addChild($builder->getElement('select', [
            'name'        => 'status',
            'label'       => $this->trans('product.label.statuses'),
            'options'     => $this->get('product_status.dataset.admin')->getResult('select'),
            'transformer' => $builder->getRepositoryTransformer('collection', $this->get('product_status.repository'))
        ]))->setValue(current($statusKeys));
    }
}
