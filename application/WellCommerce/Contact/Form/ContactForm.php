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
namespace WellCommerce\Contact\Form;

use WellCommerce\Core\Form\AbstractForm;
use WellCommerce\Core\Form\Builder\FormBuilderInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Contact\Model\Contact;

/**
 * Class ContactForm
 *
 * @package WellCommerce\Contact\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->addCheckBox([
            'name'  => 'enabled',
            'label' => $this->trans('Enabled'),
        ]));

        $translationData = $form->addChild($builder->addFieldset([
            'name'  => 'translation_data',
            'label' => $this->trans('Translations')
        ]));

        $languageData = $translationData->addChild($builder->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Translations'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleLanguageUnique($this->trans('Name already exists'),
                    [
                        'table'   => 'contact_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'contact_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'email',
            'label' => $this->trans('E-mail'),
            'rules' => [
                $builder->addRuleRequired($this->trans('E-mail is required')),
                $builder->addRuleEmail('E-mail is not valid')
            ]
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'phone',
            'label' => $this->trans('Phone'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'streetno',
            'label' => $this->trans('Street number'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'flatno',
            'label' => $this->trans('Flat number'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'postcode',
            'label' => $this->trans('Post code'),
        ]));

        $languageData->addChild($builder->addTextField([
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $languageData->addChild($builder->addSelect([
            'name'    => 'country',
            'label'   => $this->trans('Country'),
            'options' => $builder->makeOptions($this->get('country.repository')->all())
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares form data using retrieved model
     *
     * @param Contact $contact Model
     *
     * @return array
     */
    public function prepareData(Contact $contact)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $contact->translation->getTranslations();

        $accessor->setValue($formData, '[required_data]', [
            'enabled' => $contact->enabled
        ]);

        $accessor->setValue($formData, '[translation_data]', [
            'language_data' => $languageData
        ]);

        return $formData;
    }
}
