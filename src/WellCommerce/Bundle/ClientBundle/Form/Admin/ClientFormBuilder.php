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
namespace WellCommerce\Bundle\ClientBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ClientFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.fieldset.required_data')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'firstName',
            'label' => $this->trans('common.label.address.first_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('common.label.address.last_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('common.label.contact_details.email'),
        ]));

        $requiredData->addChild($this->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('common.label.password'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('common.label.contact_details.phone'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'group',
            'label'       => $this->trans('client.label.client_group'),
            'options'     => $this->get('client_group.dataset')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('client_group.repository'))
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'discount',
            'label'   => $this->trans('client.label.discount'),
            'suffix'  => '%',
            'filters' => [
                $this->getFilter('comma_to_dot_changer'),
            ],
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
