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
namespace WellCommerce\Bundle\AppBundle\Form\Front;

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

        $form->addChild($this->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('client.label.username'),
        ]));

        $form->addChild($this->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('client.label.password'),
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
