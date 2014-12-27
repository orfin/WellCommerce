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
namespace WellCommerce\Bundle\CmsBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

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
        $requiredData = $form->addContainer($this->getContainer('element_container', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addElement($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('contact.required_data.enabled.label'),
        ]));

        $languageData = $requiredData->addElement($this->getElement('fieldset_language', [
            'name'      => 'translations',
            'label'     => $this->trans('form.required_data.language_data.label'),
            'languages' => $this->get('locale.repository')->getAvailableLocales()
        ]));

        $languageData->addElement($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('address.name'),
            'rules' => [
                $this->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        print_r($form);
        die();



        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('address.email'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('address.phone'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'business_hours',
            'label' => $this->trans('contact.business_hours'),
        ]));

        $addressData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('fieldset.address_data')
        ]));

        $languageData = $addressData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.address_data.translation')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('address.street'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('address.street_no'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('address.flat_no'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('address.province'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('address.post_code'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('address.city'),
        ]));

        $languageData->addChild($builder->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('address.country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $form->addFilter($builder->getFilter('no_code'));
        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

        return $form;
    }
}
