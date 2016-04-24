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
namespace WellCommerce\Bundle\ContactBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ContactFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'requiredData',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('common.label.enabled'),
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('common.label.email'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('common.label.phone'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'businessHours',
            'label' => $this->trans('contact.label.business_hours'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'addressData',
            'label' => $this->trans('common.label.address')
        ]));

        $languageData = $addressData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'line1',
            'label' => $this->trans('address.label.line1'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'line2',
            'label' => $this->trans('address.label.line2'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'state',
            'label' => $this->trans('address.label.state'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'postalCode',
            'label' => $this->trans('address.label.post_code'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('address.label.city'),
        ]));

        $languageData->addChild($this->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('address.label.country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
