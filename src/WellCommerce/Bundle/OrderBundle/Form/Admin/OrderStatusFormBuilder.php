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
 * Class OrderStatusFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('common.label.enabled'),
            'comment' => $this->trans('order_status.comment.enabled'),
            'default' => 1
        ]));
    
        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'colour',
            'label'   => $this->trans('order_status.label.colour'),
            'default' => '#000'
        ]));
        
        $orderStatusGroups = $this->get('order_status_group.dataset.admin')->getResult('select');

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'orderStatusGroup',
            'label'       => $this->trans('order_status.label.order_status_group'),
            'options'     => $orderStatusGroups,
            'default'     => current(array_keys($orderStatusGroups)),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status_group.repository'))
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('order_status.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'defaultComment',
            'label' => $this->trans('order_status.label.default_comment')
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
