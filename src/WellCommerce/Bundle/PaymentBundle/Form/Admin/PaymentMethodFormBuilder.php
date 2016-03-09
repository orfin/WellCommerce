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
namespace WellCommerce\Bundle\PaymentBundle\Form\Admin;

use Symfony\Component\PropertyAccess\PropertyPath;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\Elements\FormInterface;

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
        $options    = [];
        $processors = $this->getProcessors();
        foreach ($processors as $processor) {
            $options[$processor->getAlias()] = $processor->getName();
        }

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('payment_method.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $processorType = $requiredData->addChild($this->getElement('select', [
            'name'    => 'processor',
            'label'   => $this->trans('payment_method.label.processor'),
            'options' => $options
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'  => 'enabled',
            'label' => $this->trans('common.label.enabled'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('common.label.hierarchy'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'defaultOrderStatus',
            'label'       => $this->trans('common.label.default_order_status'),
            'options'     => $this->get('order_status.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository'))
        ]));

        $shippingMethodsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shipping_methods_data',
            'label' => $this->trans('payment_method.fieldset.shipping_methods')
        ]));

        $shippingMethodsData->addChild($this->getElement('multi_select', [
            'name'        => 'shippingMethods',
            'label'       => $this->trans('payment_method.label.shipping_methods'),
            'options'     => $this->get('shipping_method.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shipping_method.repository'))
        ]));

        $repository = $this->get('payment_method_configuration.repository');

        $configurationData = $form->addChild($this->getElement('nested_fieldset', [
            'name'          => 'configuration',
            'property_path' => new PropertyPath('configuration'),
            'label'         => $this->trans('common.fieldset.general'),
            'transformer'   => $this->getRepositoryTransformer('payment_method_configuration', $repository)
        ]));

        foreach ($processors as $processor) {

            $dependency = $this->getDependency('show', [
                'form'      => $form,
                'field'     => $processorType,
                'condition' => new Equals($processor->getAlias())
            ]);

            $processor->addConfigurationFields($this, $configurationData, $dependency);
        }

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Returns the collection of payment method processors
     *
     * @return \WellCommerce\Bundle\AppBundle\Service\PaymentMethod\Processor\PaymentMethodProcessorInterface[]
     */
    protected function getProcessors()
    {
        return $this->get('payment_method.processor.collection')->all();
    }
}
