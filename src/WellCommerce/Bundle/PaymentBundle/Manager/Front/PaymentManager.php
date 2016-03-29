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
use WellCommerce\Bundle\OrderBundle\Exception\OrderNotFoundException;
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Exception\InvalidPaymentTokenException;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface;

/**
 * Class PaymentManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentManager extends AbstractFrontManager implements PaymentManagerInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    
    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function setOrderRepository(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    
    /**
     * {@inheritdoc}
     */
    public function findOrder() : OrderInterface
    {
        $id    = $this->getRequestHelper()->getSessionAttribute('orderId');
        $order = $this->orderRepository->find($id);
        
        if (!$order instanceof OrderInterface) {
            throw new OrderNotFoundException($id);
        }
        
        return $order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function createPayment(OrderInterface $order, PaymentMethodProcessorInterface $processor) : PaymentInterface
    {
        $configuration = $processor->processConfiguration($order->getPaymentMethod()->getConfiguration());
        $payment       = $this->repository->findOneBy(['order' => $order]);
        if (!$payment instanceof PaymentInterface) {
            $payment = $this->initResource();
            $payment->setOrder($order);
            $payment->setProcessor($processor->getAlias());
            $payment->setConfiguration($configuration);
            $this->createResource($payment);
        }
        
        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function findProcessorPaymentByToken(string $processor, string $token) : PaymentInterface
    {
        $payment = $this->repository->findOneBy(['processor' => $processor, 'token' => $token]);
        if (!$payment instanceof PaymentInterface) {
            throw new InvalidPaymentTokenException($token);
        }

        return $payment;
    }
}
