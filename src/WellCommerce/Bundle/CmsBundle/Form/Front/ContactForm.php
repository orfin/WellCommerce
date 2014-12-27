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
namespace WellCommerce\Bundle\CmsBundle\Form\Front;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class ContactForm
 *
 * @package WellCommerce\Bundle\CmsBundle\Form\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($builder->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('contact.required_data.enabled.label'),
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('address.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

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
