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
namespace WellCommerce\Bundle\CmsBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class ContactFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
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

        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('contact.required_data.enabled.label'),
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'      => 'translations',
            'label'     => $this->trans('form.required_data.language_data.label'),
            'languages' => $this->get('locale.repository')->getAvailableLocales()
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('address.name'),
            'rules' => [
                $this->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('address.email'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('address.phone'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'business_hours',
            'label' => $this->trans('contact.business_hours'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('fieldset.address_data')
        ]));

        $languageData = $addressData->addChild($this->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.address_data.translation')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('address.street'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('address.street_no'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('address.flat_no'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('address.province'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('address.post_code'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('address.city'),
        ]));

        $languageData->addChild($this->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('address.country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
