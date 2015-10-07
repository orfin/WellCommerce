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

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

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
            'label' => $this->trans('admin.form.label.required_data')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('admin.form.label.enabled'),
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('admin.form.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('contact.label.name'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('contact.label.email'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('contact.label.phone'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'businessHours',
            'label' => $this->trans('contact.label.business_hours'),
        ]));

        $addressData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'addressData',
            'label' => $this->trans('contact.label.address')
        ]));

        $languageData = $addressData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('admin.form.label.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('contact.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('address.label.street'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('address.label.street_no'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('address.label.flat_no'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('address.label.province'),
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'postCode',
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
