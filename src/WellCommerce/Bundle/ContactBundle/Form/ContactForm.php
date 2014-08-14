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
namespace WellCommerce\Bundle\ContactBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\ContactBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\ContactBundle\Repository\ContactRepositoryInterface;

/**
 * Class ContactForm
 *
 * @package WellCommerce\Contact\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactForm extends AbstractForm implements FormInterface
{
    /**
     * @var ContactRepositoryInterface
     */
    private $repository;

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
            'name'  => 'required_data_translation',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('contact.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('contact.email'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'phone',
            'label' => $this->trans('contact.phone'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'business_hours',
            'label' => $this->trans('contact.business_hours'),
        ]));

        $addressData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]));

        $languageData = $addressData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'address_data_translation',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('Street number'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('Flat number'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('Post code'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $languageData->addChild($builder->getElement('select', [
            'name'    => 'country',
            'label'   => $this->trans('Country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Prepares form data using retrieved entity
     *
     * @param Contact $Contact
     *
     * @return array
     */
    public function getDefaultData(Contact $contact)
    {
        $formData     = [];
        $languageData = [];
        $accessor     = $this->getPropertyAccessor();
        $translations = $contact->getTranslations();

        foreach ($translations as $translation) {
            $languageData['name'][$translation->getLocale()]           = $translation->getName();
            $languageData['business_hours'][$translation->getLocale()] = $translation->getBusinessHours();
            $languageData['email'][$translation->getLocale()]          = $translation->getBusinessHours();
            $languageData['phone'][$translation->getLocale()]          = $translation->getBusinessHours();
            $languageData['street'][$translation->getLocale()]         = $translation->getStreet();
            $languageData['streetNo'][$translation->getLocale()]       = $translation->getStreetNo();
            $languageData['flatNo'][$translation->getLocale()]         = $translation->getFlatNo();
            $languageData['province'][$translation->getLocale()]       = $translation->getProvince();
            $languageData['postCode'][$translation->getLocale()]       = $translation->getPostCode();
            $languageData['city'][$translation->getLocale()]           = $translation->getCity();
            $languageData['country'][$translation->getLocale()]        = $translation->getCountry();
        }

        $accessor->setValue($formData, '[required_data]', [
            'enabled'                   => $contact->getEnabled(),
            'required_data_translation' => $languageData
        ]);

        $accessor->setValue($formData, '[address_data]', [
            'address_data_translation' => $languageData
        ]);

        return $formData;
    }

    /**
     * Sets client group repository
     *
     * @param ContactRepositoryInterface $repository
     */
    public function setRepository(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
