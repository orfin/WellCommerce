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

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusHistoryInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;
use WellCommerce\Bundle\OrderBundle\Factory\OrderProductFactory;
use WellCommerce\Bundle\OrderBundle\Factory\OrderTotalFactory;

/**
 * Class OrderManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderManager extends AbstractFrontManager
{
    /**
     * @var OrderProductFactory
     */
    protected $orderProductFactory;
    
    /**
     * @var OrderTotalFactory
     */
    protected $orderTotalFactory;
    
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;
    
    /**
     * @var \WellCommerce\Bundle\OrderBundle\EventDispatcher\OrderEventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /**
     * @param OrderProductFactory $orderProductFactory
     */
    public function setOrderProductFactory(OrderProductFactory $orderProductFactory)
    {
        $this->orderProductFactory = $orderProductFactory;
    }
    
    /**
     * @param OrderTotalFactory $orderTotalFactory
     */
    public function setOrderTotalFactory(OrderTotalFactory $orderTotalFactory)
    {
        $this->orderTotalFactory = $orderTotalFactory;
    }
    
    /**
     * @param CartManagerInterface $cartManager
     */
    public function setCartManager(CartManagerInterface $cartManager)
    {
        $this->cartManager = $cartManager;
    }
    
    /**
     * @param CartInterface $cart
     *
     * @return OrderInterface
     */
    public function prepareOrderFromCart(CartInterface $cart) : OrderInterface
    {
        $orderStatus = $cart->getPaymentMethod()->getPaymentPendingOrderStatus();
        $order       = $this->initResource();
        $order->setCurrency($cart->getCurrency());
        $order->setPaymentMethod($cart->getPaymentMethod());
        $order->setShippingMethod($cart->getShippingMethodCost()->getShippingMethod());
        $order->setBillingAddress($cart->getBillingAddress());
        $order->setShippingAddress($cart->getShippingAddress());
        $order->setContactDetails($cart->getContactDetails());
        $order->setShop($cart->getShop());
        $order->setSessionId($cart->getSessionId());
        $order->setClient($cart->getClient());
        $order->setCurrentStatus($orderStatus);
        $order->setCoupon($cart->getCoupon());
        
        $this->prepareOrderStatusHistory($order, $orderStatus);
        $this->prepareOrderProducts($cart, $order);
        $this->prepareOrderShippingDetails($cart, $order);
        
        $this->eventDispatcher->dispatchOnPostOrderPrepared($order);
        
        return $order;
    }
    
    protected function prepareOrderStatusHistory(OrderInterface $order, OrderStatusInterface $orderStatus)
    {
        /** @var $orderStatusHistory OrderStatusHistoryInterface */
        $orderStatusHistory = $this->get('order_status_history.factory')->create();
        $orderStatusHistory->setNotify(true);
        $orderStatusHistory->setComment('');
        $orderStatusHistory->setOrder($order);
        $orderStatusHistory->setOrderStatus($orderStatus);

        $order->addOrderStatusHistory($orderStatusHistory);
    }
    
    /**
     * Adds all products to order
     *
     * @param CartInterface  $cart
     * @param OrderInterface $order
     */
    protected function prepareOrderProducts(CartInterface $cart, OrderInterface $order)
    {
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use ($order) {
            $orderProduct = $this->prepareOrderProduct($cartProduct, $order);
            $orderProduct->setOrder($order);
            $order->addProduct($orderProduct);
        });
    }
    
    protected function prepareOrderShippingDetails(CartInterface $cart, OrderInterface $order)
    {
        $cost        = $cart->getShippingMethodCost()->getCost();
        $grossAmount = $this->getCurrencyHelper()->convert($cost->getGrossAmount(), $cost->getCurrency(), $order->getCurrency());
        $taxRate     = $cost->getTaxRate();
        $orderTotal  = $this->orderTotalFactory->createFromSpecifiedValues($grossAmount, $taxRate, $order->getCurrency());
        
        $order->setShippingTotal($orderTotal);
    }
    
    /**
     * @param CartProductInterface $cartProduct
     * @param OrderInterface       $order
     *
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface
     */
    public function prepareOrderProduct(CartProductInterface $cartProduct, OrderInterface $order)
    {
        $orderProduct   = $this->orderProductFactory->create();
        $product        = $cartProduct->getProduct();
        $variant        = $cartProduct->getVariant();
        $sellPrice      = $cartProduct->getSellPrice();
        $baseCurrency   = $sellPrice->getCurrency();
        $targetCurrency = $order->getCurrency();
        
        $grossAmount = $this->getCurrencyHelper()->convert($sellPrice->getFinalGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalTaxAmount(), $baseCurrency, $targetCurrency);
        
        $sellPrice = new Price();
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setTaxRate($sellPrice->getTaxRate());
        $sellPrice->setCurrency($targetCurrency);
        
        $orderProduct->setSellPrice($sellPrice);
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setQuantity($cartProduct->getQuantity());
        $orderProduct->setWeight($cartProduct->getWeight());
        $orderProduct->setVariant($variant);
        $orderProduct->setProduct($product);
        
        return $orderProduct;
    }
}
