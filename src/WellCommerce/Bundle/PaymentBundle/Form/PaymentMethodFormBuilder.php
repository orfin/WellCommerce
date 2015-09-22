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
namespace WellCommerce\Bundle\PaymentBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class PaymentMethodFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $processors       = $this->getProcessors();
        $options          = [];
        $defaultProcessor = null;

        foreach ($processors as $processor) {
            if (null === $defaultProcessor) {
                $defaultProcessor = $processor->getAlias();
            }
            $options[$processor->getAlias()] = $processor->getName();
        }

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('Translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('payment_method.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('payment_method.label.name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'processor',
            'label'   => $this->trans('payment_method.label.processor'),
            'options' => $options,
            'default' => $defaultProcessor
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('payment_method.label.enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('payment_method.label.hierarchy'),
            'default' => 0
        ]));

        $shippingMethodsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shipping_methods_data',
            'label' => $this->trans('payment_method.label.shipping_methods')
        ]));

        $shippingMethodsData->addChild($this->getElement('multi_select', [
            'name'        => 'shippingMethods',
            'label'       => $this->trans('payment_method.label.shipping_methods'),
            'options'     => $this->get('shipping_method.collection.admin')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shipping_method.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    /**
     * Returns shipping method calculators as a select
     *
     * @return array|\WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface[]
     */
    protected function getProcessors()
    {
        return $this->get('payment_method.processor.collection')->all();
    }
}
