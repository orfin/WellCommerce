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

namespace WellCommerce\Bundle\OrderBundle\Visitor;

use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Generator\OrderNumberGeneratorInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\PaymentManagerInterface;

/**
 * Class OrderConfirmationVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderConfirmationVisitor implements OrderVisitorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    private $orderNumberGenerator;
    
    /**
     * @var PaymentManagerInterface
     */
    private $paymentManager;
    
    /**
     * OrderConfirmationVisitor constructor.
     *
     * @param OrderNumberGeneratorInterface $orderNumberGenerator
     * @param PaymentManagerInterface       $paymentManager
     */
    public function __construct(OrderNumberGeneratorInterface $orderNumberGenerator, PaymentManagerInterface $paymentManager)
    {
        $this->orderNumberGenerator = $orderNumberGenerator;
        $this->paymentManager       = $paymentManager;
    }
    
    public function visitOrder(OrderInterface $order)
    {
        if ($order->isConfirmed()) {
            $this->setOrderNumber($order);
            $this->setInitialOrderStatus($order);
            $this->setInitialPayment($order);
            $this->lockProducts($order);
        }
    }
    
    private function setOrderNumber(OrderInterface $order)
    {
        if (null === $order->getNumber()) {
            $orderNumber = $this->orderNumberGenerator->generateOrderNumber($order);
            $order->setNumber($orderNumber);
        }
    }
    
    private function setInitialOrderStatus(OrderInterface $order)
    {
        if (false === $order->hasCurrentStatus()) {
            $paymentMethod = $order->getPaymentMethod();
            $order->setCurrentStatus($paymentMethod->getPaymentPendingOrderStatus());
        }
    }
    
    private function setInitialPayment(OrderInterface $order)
    {
        $payments = $order->getPayments();
        if (0 === $payments->count()) {
            $payment = $this->paymentManager->createPaymentForOrder($order);
            $order->addPayment($payment);
        }
    }
    
    private function lockProducts(OrderInterface $order)
    {
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) {
            if ($orderProduct->getProduct()->getTrackStock()) {
                $this->decrementStock($orderProduct);
            }
            
            $orderProduct->setLocked(true);
        });
    }
    
    private function decrementStock(OrderProductInterface $orderProduct)
    {
        if ($orderProduct->hasVariant()) {
            $currentStock = $orderProduct->getVariant()->getStock();
            $orderProduct->getVariant()->setStock($currentStock - $orderProduct->getQuantity());
        } else {
            $currentStock = $orderProduct->getProduct()->getStock();
            $orderProduct->getProduct()->setStock($currentStock - $orderProduct->getQuantity());
        }
    }
}
