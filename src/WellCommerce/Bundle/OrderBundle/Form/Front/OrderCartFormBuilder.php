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
namespace WellCommerce\Bundle\OrderBundle\Form\Front;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Provider\Front\OrderProviderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Context\OrderContext;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodOptionsProviderInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Elements\Optioned\RadioGroup;

/**
 * Class CartFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderCartFormBuilder extends AbstractFormBuilder
{
    public function buildForm(FormInterface $form)
    {
        $order = $this->getOrderProvider()->getCurrentOrder();
        
        $shippingAddress = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shippingAddress',
            'label' => $this->trans('client.heading.shipping_address'),
        ]));
        
        $shippingAddress->addChild($this->getElement('select', [
            'name'    => 'shippingAddress.country',
            'label'   => $this->trans('client.label.address.country'),
            'options' => $this->get('country.repository')->all(),
            'default' => $this->getShopStorage()->getCurrentShop()->getDefaultCountry(),
        ]));
        
        $shippingMethods = $form->addChild($this->getElement('radio_group', [
            'name'        => 'shippingMethod',
            'label'       => $this->trans('order.label.shipping_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('shipping_method.repository')),
        ]));
        
        $this->addShippingMethods($order, $shippingMethods);
        
        $this->addShippingOptions($order, $form);
        
        $paymentMethods = $form->addChild($this->getElement('radio_group', [
            'name'        => 'paymentMethod',
            'label'       => $this->trans('order.label.payment_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('payment_method.repository')),
        ]));
        
        $this->addPaymentMethods($order, $paymentMethods);
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
    
    /**
     * Adds shipping options if available for order's shipping method
     *
     * @param OrderInterface $order
     * @param FormInterface  $form
     */
    private function addShippingOptions(OrderInterface $order, FormInterface $form)
    {
        if ($order->hasShippingMethod()) {
            $provider = $this->getOptionsProvider($order->getShippingMethod());
            if ($provider instanceof ShippingMethodOptionsProviderInterface) {
                $form->addChild($this->getElement('select', [
                    'name'    => 'shippingMethodOption',
                    'label'   => $this->trans('order.label.shipping_method'),
                    'options' => $provider->getShippingOptions(),
                ]));
            }
        }
    }
    
    /**
     * Adds shipping method options to select
     *
     * @param OrderInterface              $order
     * @param ElementInterface|RadioGroup $radioGroup
     */
    private function addShippingMethods(OrderInterface $order, ElementInterface $radioGroup)
    {
        $collection    = $this->getShippingMethodProvider()->getCosts(new OrderContext($order));
        
        $collection->map(function (ShippingMethodCostInterface $shippingMethodCost) use ($radioGroup) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $shippingMethodCost->getCost()->getGrossAmount();
            
            $label = [
                'name'    => $shippingMethod->translate()->getName(),
                'comment' => $this->getCurrencyHelper()->convertAndFormat($grossAmount, $baseCurrency),
            ];
            
            $radioGroup->addOptionToSelect($shippingMethod->getId(), $label);
        });
    }
    
    /**
     * Adds payment method options to select
     *
     * @param OrderInterface              $order
     * @param ElementInterface|RadioGroup $radioGroup
     */
    private function addPaymentMethods(OrderInterface $order, ElementInterface $radioGroup)
    {
        $order = $this->getOrderProvider()->getCurrentOrder();
        
        if ($order->hasShippingMethod()) {
            $collection = $order->getShippingMethod()->getPaymentMethods();
            
            $collection->map(function (PaymentMethodInterface $paymentMethod) use ($radioGroup) {
                if ($paymentMethod->isEnabled()) {
                    $radioGroup->addOptionToSelect($paymentMethod->getId(), $paymentMethod->translate()->getName());
                }
            });
        }
    }
    
    private function getShippingMethodProvider() : ShippingMethodProviderInterface
    {
        return $this->get('shipping_method.provider');
    }
    
    private function getOrderProvider() : OrderProviderInterface
    {
        return $this->get('order.provider.front');
    }
    
    private function getOptionsProvider(ShippingMethodInterface $method)
    {
        $provider   = $method->getOptionsProvider();
        $collection = $this->get('shipping_method.options_provider.collection');
        
        if ($collection->containsKey($provider)) {
            return $collection->get($provider);
        }
        
        return null;
    }
}
