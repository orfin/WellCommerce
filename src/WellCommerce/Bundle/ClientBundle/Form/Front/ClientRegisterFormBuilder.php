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
namespace WellCommerce\Bundle\ClientBundle\Form\Front;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ClientRegisterFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRegisterFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('client.heading.contact_details'),
        ]));
        
        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.firstName',
            'label' => $this->trans('client.label.contact_details.first_name'),
        ]));
        
        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.lastName',
            'label' => $this->trans('client.label.contact_details.last_name'),
        ]));
        
        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.phone',
            'label' => $this->trans('client.label.contact_details.phone'),
        ]));
        
        $clientDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'clientDetails',
            'label' => $this->trans('client.heading.client'),
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
            'name'    => 'clientDetails.conditionsAccepted',
            'label'   => $this->trans('client.label.accept_conditions'),
            'default' => false,
            'comment' => $this->trans('client.label.accept_conditions')
        ]));
        
        $clientDetails->addChild($this->getElement('checkbox', [
            'name'    => 'clientDetails.newsletterAccepted',
            'label'   => $this->trans('client.label.accept_newsletter'),
            'comment' => $this->trans('client.label.accept_newsletter'),
        ]));
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
