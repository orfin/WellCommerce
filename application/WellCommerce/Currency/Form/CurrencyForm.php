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
namespace WellCommerce\Currency\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Currency\Model\Currency;

/**
 * Class CurrencyForm
 *
 * @package WellCommerce\Currency\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic information')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required'))
            ]
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'symbol',
            'label'   => $this->trans('Symbol'),
            'options' => $builder->makeOptions($this->get('currency.repository')->getCurrencySymbols()),
            'rules'   => [
                $builder->addRuleRequired($this->trans('Symbol is required'))
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'decimal_separator',
            'label' => $this->trans('Decimal separator'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Decimal separator is required'))
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'decimal_count',
            'label' => $this->trans('Decimal count'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Decimal count is required'))
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'thousand_separator',
            'label' => $this->trans('Thousands separator')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'positive_prefix',
            'label' => $this->trans('Positive prefix')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'positive_suffix',
            'label' => $this->trans('Positive suffix')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'negative_prefix',
            'label' => $this->trans('Negative prefix')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'negative_suffix',
            'label' => $this->trans('Negative suffix')
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
    public function prepareData(Currency $currency)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();

        $accessor->setValue($formData, '[required_data]', [
            'name'               => $currency->name,
            'symbol'             => $currency->symbol,
            'decimal_separator'  => $currency->decimal_separator,
            'decimal_count'      => $currency->decimal_count,
            'thousand_separator' => $currency->thousand_separator,
            'positive_prefix'    => $currency->positive_prefix,
            'positive_suffix'    => $currency->positive_suffix,
            'negative_prefix'    => $currency->negative_prefix,
            'negative_suffix'    => $currency->negative_suffix
        ]);

        return $formData;
    }
}
