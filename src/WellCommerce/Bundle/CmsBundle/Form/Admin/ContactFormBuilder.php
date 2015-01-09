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
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

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
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('contact.enabled.label'),
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.required_data.language_data.label'),
            'transformer' => new TranslationTransformer($this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('contact.name.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('contact.email.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('contact.phone.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'businessHours',
            'label' => $this->trans('contact.business_hours.label'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'addressData',
            'label' => $this->trans('contact.address.label')
        ]));

        $languageData = $addressData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('contact.translations.label'),
            'transformer' => new TranslationTransformer($this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('contact.street.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('contact.street_no.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('contact.flat_no.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('contact.province.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('contact.post_code.label'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('contact.city.label'),
        ]));

        $languageData->addChild($this->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('contact.country.label'),
            'options' => $this->get('country.repository')->all()
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
