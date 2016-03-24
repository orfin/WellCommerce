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
namespace WellCommerce\Bundle\OrderBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class OrderStatusHistoryFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusHistoryFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $orderStatuses = $this->get('order_status.dataset.admin')->getResult('select');
        
        $form->addChild($this->getElement('select', [
            'name'        => 'orderStatus',
            'label'       => $this->trans('order_status_history.label.order_status'),
            'options'     => $orderStatuses,
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository'))
        ]));

        $form->addChild($this->getElement('text_area', [
            'name'  => 'comment',
            'rows'  => 10,
            'label' => $this->trans('order_status_history.label.comment')
        ]));

        $form->addChild($this->getElement('checkbox', [
            'name'    => 'notify',
            'label'   => $this->trans('order_status_history.label.nofity'),
            'default' => 1
        ]));

        $form->addChild($this->getElement('submit', [
            'name'  => 'add_order_status_history',
            'label' => $this->trans('order_status_history.button.change'),
        ]));
        
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
