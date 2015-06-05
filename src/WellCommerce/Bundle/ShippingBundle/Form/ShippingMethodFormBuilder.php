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
use WellCommerce\Bundle\FormBundle\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

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
        $calculators = $this->getCalculators();
        $options     = [];

        foreach ($calculators as $calculator) {
            $options[$calculator->getAlias()] = $calculator->getName();
        }

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('Translations'),
            'transformer' => new TranslationTransformer($this->get('shipping_method.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'calculator',
            'label'   => $this->trans('Processor'),
            'options' => $options
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('Hierarchy'),
            'default' => 0
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Returns shipping method calculators as a select
     *
     * @return array|\WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorInterface[]
     */
    protected function getCalculators()
    {
        return $this->get('shipping_method.calculator.collection')->all();
    }
}
