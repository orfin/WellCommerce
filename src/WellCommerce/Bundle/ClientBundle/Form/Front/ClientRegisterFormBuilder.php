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
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

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
        $billingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'billingAddress',
            'label' => $this->trans('address.heading.billing_address'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.firstName',
            'label' => $this->trans('address.label.first_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.lastName',
            'label' => $this->trans('address.label.last_name'),
        ]));

        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('contact_details.heading.details'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.phone',
            'label' => $this->trans('contact_details.label.phone'),
        ]));

        $form->addChild($this->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('contact_details.label.username'),
        ]));

        $form->addChild($this->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('common.label.password'),
        ]));

        $form->addChild($this->getElement('checkbox', [
            'name'  => 'conditionsAccepted',
            'label' => $this->trans('client.label.accept_conditions'),
        ]));

        $form->addChild($this->getElement('checkbox', [
            'name'  => 'newsletterAccepted',
            'label' => $this->trans('client.label.accept_newsletter'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
