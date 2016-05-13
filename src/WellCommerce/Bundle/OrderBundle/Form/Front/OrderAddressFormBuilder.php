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
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class OrderAddressFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderAddressFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $countries      = $this->get('country.repository')->all();
        $defaultCountry = $this->getShopStorage()->getCurrentShop()->getDefaultCountry();

        $billingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'billingAddress',
            'label' => $this->trans('address.heading.billing_address'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.firstName',
            'label' => $this->trans('common.label.first_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.lastName',
            'label' => $this->trans('common.label.last_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'    => 'billingAddress.line1',
            'label'   => $this->trans('address.label.line1'),
            'comment' => $this->trans('address.comment.line1'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'    => 'billingAddress.line2',
            'label'   => $this->trans('address.label.line2'),
            'comment' => $this->trans('address.comment.line2'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.postalCode',
            'label' => $this->trans('address.label.postal_code'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.state',
            'label' => $this->trans('address.label.state'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.city',
            'label' => $this->trans('address.label.city'),
        ]));

        $billingAddress->addChild($this->getElement('select', [
            'name'    => 'billingAddress.country',
            'label'   => $this->trans('address.label.country'),
            'options' => $countries,
            'default' => $defaultCountry
        ]));

        $shippingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shippingAddress',
            'label' => $this->trans('address.heading.shipping_address'),
        ]));
    
        $shippingAddress->addChild($this->getElement('checkbox', [
            'name'  => 'shippingAddress.copyBillingAddress',
            'label' => $this->trans('address.label.copy_address'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.firstName',
            'label' => $this->trans('common.label.first_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.lastName',
            'label' => $this->trans('common.label.last_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'    => 'shippingAddress.line1',
            'label'   => $this->trans('address.label.line1'),
            'comment' => $this->trans('address.comment.line1'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'    => 'shippingAddress.line2',
            'label'   => $this->trans('address.label.line2'),
            'comment' => $this->trans('address.comment.line2'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.postalCode',
            'label' => $this->trans('address.label.postal_code'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.state',
            'label' => $this->trans('address.label.state'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.city',
            'label' => $this->trans('address.label.city'),
        ]));

        $shippingAddress->addChild($this->getElement('select', [
            'name'    => 'shippingAddress.country',
            'label'   => $this->trans('address.label.country'),
            'options' => $countries,
            'default' => $defaultCountry
        ]));

        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('address.heading.contact_details'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.firstName',
            'label' => $this->trans('common.label.first_name'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.lastName',
            'label' => $this->trans('common.label.last_name'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.phone',
            'label' => $this->trans('common.label.phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.secondaryPhone',
            'label' => $this->trans('common.label.secondary_phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.email',
            'label' => $this->trans('common.label.email'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
