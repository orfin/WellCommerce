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

namespace WellCommerce\Bundle\OrderBundle\Manager\Front;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifier;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierDetails;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;

/**
 * Class OrderManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderManager extends AbstractFrontManager
{
    public function prepareOrder(Cart $cart)
    {
        $currency = $this->getRequestHelper()->getSessionAttribute('_currency');
        $order    = new Order();
        $order->setPaymentMethod($cart->getPaymentMethod());
        $order->setShippingMethod($cart->getShippingMethod());
        $order->setBillingAddress($cart->getBillingAddress());
        $order->setShippingAddress($cart->getShippingAddress());
        $order->setShop($cart->getShop());
        $order->setSessionId($cart->getSessionId());
        $order->setClient($cart->getClient());
        $order->setCurrency($currency);
        $order->setCurrentStatus($cart->getShop()->getDefaultOrderStatus());

        $this->prepareOrderProducts($cart, $order);
        $this->prepareOrderModifiers($cart, $order);

        return $order;
    }

    protected function prepareOrderProducts(Cart $cart, Order $order)
    {
        $cartProducts  = $cart->getProducts();
        $orderProducts = new ArrayCollection();

        foreach ($cartProducts as $cartProduct) {
            $netPrice     = $cartProduct->getProduct()->getSellPrice()->getAmount();
            $grossPrice   = $cartProduct->getProduct()->getSellPriceTax()->calculateGrossPrice($netPrice);
            $orderProduct = new OrderProduct();
            $orderProduct->setAttribute($cartProduct->getAttribute());
            $orderProduct->setProduct($cartProduct->getProduct());
            $orderProduct->setNetPrice($netPrice);
            $orderProduct->setGrossPrice($grossPrice);
            $orderProduct->setTaxValue($grossPrice - $netPrice);
            $orderProduct->setQuantity($cartProduct->getQuantity());
            $orderProduct->setOrder($order);
            $orderProduct->setWeight($cartProduct->getProduct()->getWeight());
            $orderProducts->add($orderProduct);
        }

        $order->setProducts($orderProducts);
    }

    /**
     * Temporary method for testing order totals modification
     *
     * @param Cart  $cart
     * @param Order $order
     */
    protected function prepareOrderModifiers(Cart $cart, Order $order)
    {
        $shippingMethodCostModifierDetails = new OrderModifierDetails();
        $shippingMethodCostModifierDetails->setName('shipping');
        $shippingMethodCostModifierDetails->setDescription('Shipping costs');

        $shippingMethodCostModifier = new OrderModifier();
        $shippingMethodCostModifier->setOrder($order);
        $shippingMethodCostModifier->setIncrease(true);
        $shippingMethodCostModifier->setNetValue(10);
        $shippingMethodCostModifier->setGrossValue(12.30);
        $shippingMethodCostModifier->setTaxValue(2.30);
        $shippingMethodCostModifier->setHierarchy(10);
        $shippingMethodCostModifier->setModifierDetails($shippingMethodCostModifierDetails);

        $order->addModifier($shippingMethodCostModifier);

        $paymentMethodCostModifierDetails = new OrderModifierDetails();
        $paymentMethodCostModifierDetails->setName('payment');
        $paymentMethodCostModifierDetails->setDescription('Payment surcharge');

        $paymentMethodCostModifier = new OrderModifier();
        $paymentMethodCostModifier->setOrder($order);
        $paymentMethodCostModifier->setIncrease(true);
        $paymentMethodCostModifier->setNetValue($surchargeNet = $cart->getTotals()->getNetPrice() * 0.03);
        $paymentMethodCostModifier->setGrossValue($surchargeGross = $cart->getTotals()->getGrossPrice() * 0.03);
        $paymentMethodCostModifier->setTaxValue($surchargeGross - $surchargeNet);
        $paymentMethodCostModifier->setHierarchy(20);
        $paymentMethodCostModifier->setModifierDetails($paymentMethodCostModifierDetails);

        $order->addModifier($paymentMethodCostModifier);

        $clientDiscountModifierDetails = new OrderModifierDetails();
        $clientDiscountModifierDetails->setName('client_discount');
        $clientDiscountModifierDetails->setDescription('Client discount');

        $discountBaseNet   = ($cart->getTotals()->getNetPrice() + $surchargeNet);
        $discountBaseGross = ($cart->getTotals()->getGrossPrice() + $surchargeGross);

        $clientDiscountNet   = $discountBaseNet * 0.1;
        $clientDiscountGross = $discountBaseGross * 0.1;
        $clientDiscountTax   = ($discountBaseGross - $discountBaseNet) * 0.1;

        $clientDiscountModifier = new OrderModifier();
        $clientDiscountModifier->setOrder($order);
        $clientDiscountModifier->setIncrease(false);
        $clientDiscountModifier->setNetValue($clientDiscountNet);
        $clientDiscountModifier->setGrossValue($clientDiscountGross);
        $clientDiscountModifier->setTaxValue($clientDiscountTax);
        $clientDiscountModifier->setHierarchy(30);
        $clientDiscountModifier->setModifierDetails($clientDiscountModifierDetails);

        $order->addModifier($clientDiscountModifier);
    }
}
