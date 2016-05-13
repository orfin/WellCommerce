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
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentStateHistoryInterface;

/**
 * Class PaymentStateHistoryManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentStateHistoryManager extends Manager implements PaymentStateHistoryManagerInterface
{
    public function createPaymentStateHistory(PaymentInterface $payment) : PaymentStateHistoryInterface
    {
        /** @var PaymentStateHistoryInterface $paymentStateHistory */
        $paymentStateHistory = $this->initResource();
        $paymentStateHistory->setState($payment->getState());
        $paymentStateHistory->setPayment($payment);
        $paymentStateHistory->setComment($payment->getComment());
        $this->createResource($paymentStateHistory, false);

        return $paymentStateHistory;
    }
}
