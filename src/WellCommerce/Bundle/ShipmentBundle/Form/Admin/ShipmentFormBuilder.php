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
namespace WellCommerce\Bundle\ShipmentBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ShipmentFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $orderStatuses = $this->get('order_status.dataset.admin')->getResult('select');
        
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general'),
        ]));
    
        $requiredData->addChild($this->getElement('hidden', [
            'name'  => 'guid',
            'label' => '',
        ]));
    
        $requiredData->addChild($this->getElement('hidden', [
            'name'  => 'courier',
            'label' => '',
        ]));
        
        $requiredData->addChild($this->getElement('select', [
            'name'        => 'orderStatus',
            'label'       => $this->trans('order_status_history.label.order_status'),
            'options'     => $orderStatuses,
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository')),
        ]))->setValue(12);
        
        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'notify',
            'label' => $this->trans('order_status_history.label.nofity'),
        ]))->setValue(1);
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
