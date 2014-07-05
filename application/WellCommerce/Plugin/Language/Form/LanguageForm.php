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
namespace WellCommerce\Plugin\Language\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Language\Model\Language;

/**
 * Class LanguageForm
 *
 * @package WellCommerce\Plugin\Language\Form
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
                $builder->addRuleRequired($this->trans('Name is required'))
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
     * Prepares form data using retrieved model
     *
     * @param Currency $currency Model
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
