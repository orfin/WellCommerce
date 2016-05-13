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
use WellCommerce\Bundle\OrderBundle\Provider\Front\OrderProviderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Context\OrderContext;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
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
        $shippingMethod = $form->addChild($this->getElement('radio_group', [
            'name'        => 'shippingMethod',
            'label'       => $this->trans('cart.label.shipping_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('shipping_method.repository'))
        ]));

        $this->addShippingOptions($shippingMethod);

        $paymentMethod = $form->addChild($this->getElement('radio_group', [
            'name'        => 'paymentMethod',
            'label'       => $this->trans('cart.label.payment_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('payment_method.repository'))
        ]));

        $this->addPaymentOptions($paymentMethod);

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Adds shipping method options to select
     *
     * @param ElementInterface|RadioGroup $radioGroup
     */
    private function addShippingOptions(ElementInterface $radioGroup)
    {
        $order      = $this->getOrderProvider()->getCurrentOrder();
        $collection = $this->getShippingMethodProvider()->getCosts(new OrderContext($order));

        $collection->map(function (ShippingMethodCostInterface $shippingMethodCost) use ($radioGroup) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $shippingMethodCost->getCost()->getGrossAmount();

            $label = [
                'name'    => $shippingMethod->translate()->getName(),
                'comment' => $this->getCurrencyHelper()->convertAndFormat($grossAmount, $baseCurrency)
            ];

            $radioGroup->addOptionToSelect($shippingMethod->getId(), $label);
        });
    }

    /**
     * Adds payment method options to select
     *
     * @param ElementInterface|RadioGroup $radioGroup
     */
    private function addPaymentOptions(ElementInterface $radioGroup)
    {
        $order          = $this->getOrderProvider()->getCurrentOrder();
        $shippingMethod = $order->getShippingMethod();
        if ($shippingMethod instanceof ShippingMethodInterface) {
            $collection = $shippingMethod->getPaymentMethods();

            $collection->map(function (PaymentMethodInterface $paymentMethod) use ($radioGroup) {
                $radioGroup->addOptionToSelect($paymentMethod->getId(), $paymentMethod->translate()->getName());
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
}
