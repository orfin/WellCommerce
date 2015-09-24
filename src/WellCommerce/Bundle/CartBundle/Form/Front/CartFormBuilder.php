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
namespace WellCommerce\Bundle\CartBundle\Form\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\FormBundle\Elements\Optioned\RadioGroup;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\CartShippingMethodProviderInterface;

/**
 * Class CartFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFormBuilder extends AbstractFormBuilder
{
    /**
     * @var CartShippingMethodProviderInterface
     */
    protected $cartShippingMethodProvider;

    /**
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * @param CartShippingMethodProviderInterface $cartShippingMethodProvider
     */
    public function setShippingMethodProvider(CartShippingMethodProviderInterface $cartShippingMethodProvider)
    {
        $this->cartShippingMethodProvider = $cartShippingMethodProvider;
    }

    /**
     * @param CartProviderInterface $cartProvider
     */
    public function setCartManager(CartProviderInterface $cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $cart = $this->cartProvider->getCurrentCart();

        $shippingMethod = $form->addChild($this->getElement('radio_group', [
            'name'        => 'shippingMethodCost',
            'label'       => $this->trans('cart.shipping_method.label'),
            'options'     => [],
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('shipping_method_cost.repository'))
        ]));

        $this->addShippingOptions($shippingMethod, $cart);

        $paymentMethod = $form->addChild($this->getElement('radio_group', [
            'name'        => 'paymentMethod',
            'label'       => $this->trans('cart.payment_method.label'),
            'options'     => [],
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('payment_method.repository'))
        ]));

        $this->addPaymentOptions($paymentMethod, $cart);

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    /**
     * Adds shipping method options to select
     *
     * @param RadioGroup    $radioGroup
     * @param CartInterface $cart
     */
    protected function addShippingOptions(RadioGroup $radioGroup, CartInterface $cart)
    {
        $currencyHelper = $this->getCurrencyHelper();
        $collection     = $this->cartShippingMethodProvider->getShippingMethodCostsCollection($cart);
        foreach ($collection->all() as $cost) {
            $shippingMethod = $cost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $cost->getCost()->getGrossAmount();

            $label = [
                'name'    => $shippingMethod->translate()->getName(),
                'comment' => $currencyHelper->convertAndFormat($grossAmount, $baseCurrency)
            ];

            $radioGroup->addOptionToSelect($cost->getId(), $label);
        }
    }

    /**
     * Adds payment method options to select
     *
     * @param RadioGroup    $radioGroup
     * @param CartInterface $cart
     */
    protected function addPaymentOptions(RadioGroup $radioGroup, CartInterface $cart)
    {
        $shippingMethod = $cart->getShippingMethodCost()->getShippingMethod();
        $paymentMethods = $shippingMethod->getPaymentMethods();

        $paymentMethods->map(function (PaymentMethodInterface $paymentMethod) use ($radioGroup) {
            $radioGroup->addOptionToSelect($paymentMethod->getId(), $paymentMethod->translate()->getName());
        });
    }
}
