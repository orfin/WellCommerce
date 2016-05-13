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

use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PaymentManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentManager extends Manager implements PaymentManagerInterface
{
    public function createPaymentForOrder(OrderInterface $order) : PaymentInterface
    {
        $processor = $order->getPaymentMethod()->getProcessor();

        /** @var PaymentInterface $payment */
        $payment = $this->initResource();
        $payment->setOrder($order);
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $payment->setProcessor($processor);
        $this->createResource($payment, false);

        return $payment;
    }

    public function findPaymentByToken(string $token) : PaymentInterface
    {
        return $this->getRepository()->findOneBy(['token' => $token]);
    }
}
