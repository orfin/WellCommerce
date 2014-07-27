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
namespace WellCommerce\Language\Form;

use WellCommerce\Core\Form\AbstractForm;
use WellCommerce\Core\Form\Builder\FormBuilderInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Language\Model\Language;

/**
 * Class LanguageForm
 *
 * @package WellCommerce\Language\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic settings')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
                $builder->addRuleUnique($this->trans('Name already exists'),
                    [
                        'table'   => 'language',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'translation',
            'label' => $this->trans('Translation'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Translation is required'))
            ]
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'locale',
            'label'   => $this->trans('Preferred locale'),
            'options' => $builder->makeOptions($this->get('language.repository')->getAllLocaleToSelect())
        ]));

        $currencyData = $form->addChild($builder->addFieldset([
            'name'  => 'currency_data',
            'label' => $this->trans('Currency settings')
        ]));

        $currencyData->addChild($builder->addSelect([
            'name'    => 'currency_id',
            'label'   => $this->trans('Default currency'),
            'options' => $builder->makeOptions($this->get('currency.repository')->getAllCurrencyToSelect())
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares form data using retrieved Language model
     *
     * @param Language $language
     *
     * @return array
     */
    public function prepareData(Language $language)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();

        $accessor->setValue($formData, '[required_data]', [
            'name'        => $language->name,
            'translation' => $language->translation,
            'locale'      => $language->locale
        ]);

        $accessor->setValue($formData, '[currency_data]', [
            'currency_id' => $language->currency_id
        ]);

        return $formData;
    }
}
