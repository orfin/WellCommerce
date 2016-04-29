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

namespace WellCommerce\Bundle\PaymentBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class PaymentManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentManager extends AbstractManager implements PaymentManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createFirstPaymentForOrder(OrderInterface $order) : PaymentInterface
    {
        $processor = $order->getPaymentMethod()->getProcessor();
        $payment   = $this->initResource();
        $payment->setOrder($order);
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $payment->setProcessor($processor);
        $this->createResource($payment);
        
        return $payment;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPaymentProcessor(string $alias) : PaymentProcessorInterface
    {
        $processors = $this->get('payment.processor.collection');
        
        return $processors->get($alias);
    }
}
