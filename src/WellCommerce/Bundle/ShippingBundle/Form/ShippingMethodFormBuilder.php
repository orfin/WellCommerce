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
namespace WellCommerce\Bundle\ShippingBundle\Form;

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\ShippingBundle\Form\DataTransformer\ShippingCostCollectionToArrayTransformer;

/**
 * Class ShippingMethodForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    protected $calculators;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('fieldset.label.required_data')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('translation.label.translations'),
            'transformer' => new TranslationTransformer($this->get('shipping_method.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('shipping_method.label.name'),
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('shipping_method.label.enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('shipping_method.label.hierarchy'),
            'default' => 0
        ]));

        $costsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'costs_data',
            'label' => $this->trans('shipping_method.label.costs')
        ]));

        $costsData->addChild($this->getElement('select', [
            'name'    => 'calculator',
            'label'   => $this->trans('shipping_method.label.calculator'),
            'options' => [],
        ]));

        $costsData->addChild($this->getElement('select', [
            'name'    => 'currency',
            'label'   => $this->trans('shipping_method.label.currency'),
            'options' => $this->get('currency.provider')->getSelect()
        ]));

        $tax = $costsData->addChild($this->getElement('select', [
            'name'        => 'tax',
            'label'       => $this->trans('shipping_method.label.tax'),
            'options'     => $this->get('tax.collection')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('tax.repository'))
        ]));

        $costsData->addChild($this->getElement('range_editor', [
            'name'            => 'costs',
            'label'           => $this->trans('shipping_method.label.costs'),
            'vat_field'       => $tax,
            'range_precision' => 2,
            'transformer'     => new ShippingCostCollectionToArrayTransformer($this->get('shipping_method_cost.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
