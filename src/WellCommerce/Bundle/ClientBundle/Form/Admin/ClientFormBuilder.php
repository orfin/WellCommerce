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
use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\SelectBuilder;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
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
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'firstName',
            'label' => $this->trans('client.label.first_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('client.label.last_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('client.label.email'),
        ]));

        $requiredData->addChild($this->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('client.label.password'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('client.label.phone'),
        ]));

        $clientGroupSelectBuilder = new SelectBuilder($this->get('client_group.dataset'));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'group',
            'label'       => $this->trans('client.label.client_group'),
            'options'     => $clientGroupSelectBuilder->getItems(),
            'transformer' => new EntityToIdentifierTransformer($this->get('client_group.repository'))
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
