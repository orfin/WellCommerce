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

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

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
        $this->addClientDetailsFieldset($form);
        $this->addContactDetailsFieldset($form);
        $this->addBillingAddressFieldset($form);
        $this->addShippingAddressFieldset($form);
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    protected function addBillingAddressFieldset(FormInterface $form)
    {
        $billingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'billingAddress',
            'label' => $this->trans('client.heading.billing_address'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.firstName',
            'label' => $this->trans('client.label.contact_details.first_name'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.lastName',
            'label' => $this->trans('client.label.contact_details.last_name'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.companyName',
            'label' => $this->trans('client.label.address.company_name'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.vatId',
            'label' => $this->trans('client.label.address.vat_id'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'    => 'billingAddress.line1',
            'label'   => $this->trans('client.label.address.line1'),
            'comment' => $this->trans('client.label.address.line1'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'    => 'billingAddress.line2',
            'label'   => $this->trans('client.label.address.line2'),
            'comment' => $this->trans('client.label.address.line2'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.postalCode',
            'label' => $this->trans('client.label.address.postal_code'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.state',
            'label' => $this->trans('client.label.address.state'),
        ]));
        
        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.city',
            'label' => $this->trans('client.label.address.city'),
        ]));
        
        $billingAddress->addChild($this->getElement('select', [
            'name'    => 'billingAddress.country',
            'label'   => $this->trans('client.label.address.country'),
            'options' => $this->get('country.repository')->all(),
            'default' => $this->getShopStorage()->getCurrentShop()->getDefaultCountry()
        ]));
    }
    
    protected function addShippingAddressFieldset(FormInterface $form)
    {
        $shippingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shippingAddress',
            'label' => $this->trans('client.heading.shipping_address'),
        ]));
        
        $shippingAddress->addChild($this->getElement('checkbox', [
            'name'  => 'shippingAddress.copyBillingAddress',
            'label' => $this->trans('client.label.address.copy_address'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.firstName',
            'label' => $this->trans('client.label.address.first_name'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.lastName',
            'label' => $this->trans('client.label.address.last_name'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'    => 'shippingAddress.line1',
            'label'   => $this->trans('client.label.address.line1'),
            'comment' => $this->trans('client.label.address.line1'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'    => 'shippingAddress.line2',
            'label'   => $this->trans('client.label.address.line2'),
            'comment' => $this->trans('client.label.address.line2'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.postalCode',
            'label' => $this->trans('client.label.address.postal_code'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.state',
            'label' => $this->trans('client.label.address.state'),
        ]));
        
        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.city',
            'label' => $this->trans('client.label.address.city'),
        ]));
        
        $shippingAddress->addChild($this->getElement('select', [
            'name'    => 'shippingAddress.country',
            'label'   => $this->trans('client.label.address.country'),
            'options' => $this->get('country.repository')->all(),
            'default' => $this->getShopStorage()->getCurrentShop()->getDefaultCountry()
        ]));
    }
    
    protected function addContactDetailsFieldset(FormInterface $form)
    {
        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('client.heading.contact_details'),
        ]));
        
        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.firstName',
            'label' => $this->trans('client.label.address.first_name'),
        ]));
        
        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.lastName',
            'label' => $this->trans('client.label.address.last_name'),
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
    }
    
    protected function addClientDetailsFieldset(FormInterface $form)
    {
        if (!$this->getSecurityHelper()->getCurrentClient() instanceof ClientInterface) {
            $clientDetails = $form->addChild($this->getElement('nested_fieldset', [
                'name'  => 'clientDetails',
                'label' => $this->trans('client.heading.client'),
            ]));
            
            $clientDetails->addChild($this->getElement('checkbox', [
                'name'  => 'clientDetails.createAccount',
                'label' => $this->trans('client.label.create_account'),
            ]));
            
            $clientDetails->addChild($this->getElement('text_field', [
                'name'  => 'clientDetails.username',
                'label' => $this->trans('client.label.username'),
            ]));
            
            $clientDetails->addChild($this->getElement('password', [
                'name'  => 'clientDetails.hashedPassword',
                'label' => $this->trans('client.label.password'),
            ]));
            
            $clientDetails->addChild($this->getElement('password', [
                'name'  => 'clientDetails.passwordConfirm',
                'label' => $this->trans('client.label.confirm_password'),
            ]));
            
            $clientDetails->addChild($this->getElement('checkbox', [
                'name'  => 'clientDetails.conditionsAccepted',
                'label' => $this->trans('client.label.conditions_accepted'),
            ]));
        }
    }
}
