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

namespace WellCommerce\Bundle\PaymentBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class PaymentManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentManager extends AbstractFrontManager implements PaymentManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFirstPaymentForOrder(OrderInterface $order) : PaymentInterface
    {
        $payments = $order->getPayments();
        if (0 === $payments->count()) {
            return $this->createPayment($order);
        }
        
        return $payments->first();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPaymentProcessor(string $alias) : PaymentProcessorInterface
    {
        $processors = $this->get('payment.processor.collection');
        
        return $processors->get($alias);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function createPayment(OrderInterface $order) : PaymentInterface
    {
        /** @var $payment PaymentInterface */
        $payment       = $this->initResource();
        $paymentMethod = $order->getPaymentMethod();
        $processor     = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());

        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $payment->setOrder($order);
        $payment->setConfiguration($processor->getConfiguration($paymentMethod));
        $payment->setProcessor($processor->getConfigurator()->getName());

        $processor->preparePayment($payment);

        $this->createResource($payment);
        
        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function findPaymentByToken(string $token) : PaymentInterface
    {
        return $this->repository->findOneBy(['token' => $token]);
    }
}
