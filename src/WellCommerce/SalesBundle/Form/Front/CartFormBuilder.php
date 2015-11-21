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
namespace WellCommerce\SalesBundle\Form\Front;

use WellCommerce\CoreBundle\Component\Form\AbstractFormBuilder;
use WellCommerce\CoreBundle\Component\Form\Elements\FormInterface;
use WellCommerce\CoreBundle\Component\Form\Elements\Optioned\RadioGroup;
use WellCommerce\SalesBundle\Context\Front\CartContextInterface;
use WellCommerce\SalesBundle\Entity\CartInterface;
use WellCommerce\SalesBundle\Entity\PaymentMethodInterface;
use WellCommerce\SalesBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\SalesBundle\Provider\CartShippingMethodProviderInterface;
use WellCommerce\SalesBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class CartFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFormBuilder extends AbstractFormBuilder
{
    /**
     * @var ShippingMethodProviderInterface
     */
    protected $shippingMethodProvider;

    /**
     * @var CartContextInterface
     */
    protected $cartContext;

    /**
     * @param ShippingMethodProviderInterface $shippingMethodProvider
     */
    public function setShippingMethodProvider(ShippingMethodProviderInterface $shippingMethodProvider)
    {
        $this->shippingMethodProvider = $shippingMethodProvider;
    }

    /**
     * @param CartContextInterface $cartContext
     */
    public function setCartContext(CartContextInterface $cartContext)
    {
        $this->cartContext = $cartContext;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $cart = $this->cartContext->getCurrentCart();

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
        $collection = $this->shippingMethodProvider->getShippingMethodCostsCollection($cart);

        $collection->map(function (ShippingMethodCostInterface $shippingMethodCost) use ($radioGroup) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $shippingMethodCost->getCost()->getGrossAmount();

            $label = [
                'name'    => $shippingMethod->translate()->getName(),
                'comment' => $this->getCurrencyHelper()->convertAndFormat($grossAmount, $baseCurrency)
            ];

            $radioGroup->addOptionToSelect($shippingMethodCost->getId(), $label);
        });
    }

    /**
     * Adds payment method options to select
     *
     * @param RadioGroup    $radioGroup
     * @param CartInterface $cart
     */
    protected function addPaymentOptions(RadioGroup $radioGroup, CartInterface $cart)
    {
        $shippingMethodCost = $cart->getShippingMethodCost();
        if (null !== $shippingMethodCost) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $collection     = $shippingMethod->getPaymentMethods();

            $collection->map(function (PaymentMethodInterface $paymentMethod) use ($radioGroup) {
                $radioGroup->addOptionToSelect($paymentMethod->getId(), $paymentMethod->translate()->getName());
            });
        }
    }
}
