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

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ClientRegisterFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRegisterFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form->addChild($this->getElement('text_field', [
            'name'  => 'firstName',
            'label' => $this->trans('client.label.first_name'),
        ]));

        $form->addChild($this->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('client.label.last_name'),
        ]));

        $form->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('client.label.phone'),
        ]));

        $form->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('client.label.email'),
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
