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
    public function getFirstPaymentForOrder(OrderInterface $order, PaymentProcessorInterface $processor) : PaymentInterface
    {
        $payments = $order->getPayments();
        if (0 === $payments->count()) {
            /** @var $payment PaymentInterface */
            $payment = $this->initResource();
            $processor->preparePaymentForOrder($payment, $order);
            $this->createResource($payment);

            return $payment;
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
}
