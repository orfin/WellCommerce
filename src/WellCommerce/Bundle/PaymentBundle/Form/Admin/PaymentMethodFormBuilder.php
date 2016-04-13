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
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorCollection;
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
        $orderStatuses = $this->get('order_status.dataset.admin')->getResult('select');
        $options       = [];
        $processors    = $this->getPaymentProcessorCollection();
        foreach ($processors->all() as $processor) {
            $processorName           = $processor->getConfigurator()->getName();
            $options[$processorName] = $processorName;
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
            'options' => $options,
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
        
        $statusesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'statuses',
            'label' => $this->trans('payment_method.fieldset.order_statuses')
        ]));
        
        $statusesData->addChild($this->getElement('select', [
            'name'        => 'paymentPendingOrderStatus',
            'label'       => $this->trans('payment_method.label.payment_pending_order_status'),
            'options'     => $orderStatuses,
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository'))
        ]));

        $statusesData->addChild($this->getElement('select', [
            'name'        => 'paymentSuccessOrderStatus',
            'label'       => $this->trans('payment_method.label.payment_success_order_status'),
            'options'     => $orderStatuses,
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository'))
        ]));

        $statusesData->addChild($this->getElement('select', [
            'name'        => 'paymentFailureOrderStatus',
            'label'       => $this->trans('payment_method.label.payment_failure_order_status'),
            'options'     => $orderStatuses,
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
        
        $configurationData = $form->addChild($this->getElement('nested_fieldset', [
            'name'          => 'configuration',
            'property_path' => new PropertyPath('configuration'),
            'label'         => $this->trans('payment_method.fieldset.processor_configuration')
        ]));
        
        foreach ($processors->all() as $processor) {
            
            $dependency = $this->getDependency('show', [
                'form'      => $form,
                'field'     => $processorType,
                'condition' => new Equals($processor->getConfigurator()->getName())
            ]);
            
            $processor->getConfigurator()->addConfigurationFields($this, $configurationData, $dependency);
        }
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    protected function getPaymentProcessorCollection() : PaymentProcessorCollection
    {
        return $this->container->get('payment.processor.collection');
    }
}
