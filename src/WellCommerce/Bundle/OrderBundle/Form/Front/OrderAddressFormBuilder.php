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
namespace WellCommerce\Bundle\OrderBundle\Form\Front;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class OrderAddressFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderAddressFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $countries      = $this->get('country.repository')->all();
        $defaultCountry = $this->get('shop.context.front')->getCurrentScope()->getDefaultCountry();

        $billingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'billingAddress',
            'label' => $this->trans('client.label.billing_address'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.firstName',
            'label' => $this->trans('client.label.first_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.lastName',
            'label' => $this->trans('client.label.last_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.street',
            'label' => $this->trans('client.label.street'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.streetNo',
            'label' => $this->trans('client.label.street_no'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.flatNo',
            'label' => $this->trans('client.label.flat_no'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.postCode',
            'label' => $this->trans('client.label.post_code'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.province',
            'label' => $this->trans('client.label.province'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.city',
            'label' => $this->trans('client.label.city'),
        ]));

        $billingAddress->addChild($this->getElement('select', [
            'name'    => 'billingAddress.country',
            'label'   => $this->trans('client.label.country'),
            'options' => $countries,
            'default' => $defaultCountry
        ]));

        $shippingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shippingAddress',
            'label' => $this->trans('client.label.shipping_address'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.firstName',
            'label' => $this->trans('client.label.first_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.lastName',
            'label' => $this->trans('client.label.last_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.street',
            'label' => $this->trans('client.label.street'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.streetNo',
            'label' => $this->trans('client.label.street_no'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.flatNo',
            'label' => $this->trans('client.label.flat_no'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.postCode',
            'label' => $this->trans('client.label.post_code'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.province',
            'label' => $this->trans('client.label.province'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.city',
            'label' => $this->trans('client.label.city'),
        ]));

        $shippingAddress->addChild($this->getElement('select', [
            'name'    => 'shippingAddress.country',
            'label'   => $this->trans('client.label.country'),
            'options' => $countries,
            'default' => $defaultCountry
        ]));

        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('client.label.contact_details'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.phone',
            'label' => $this->trans('client.label.phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.secondaryPhone',
            'label' => $this->trans('client.label.secondary_phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.email',
            'label' => $this->trans('client.label.email'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
