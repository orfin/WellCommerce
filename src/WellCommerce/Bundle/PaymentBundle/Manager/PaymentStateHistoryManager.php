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
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PaymentStateHistoryManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentStateHistoryManager extends AbstractManager
{
    public function createPaymentStateHistory(PaymentInterface $payment)
    {
        $paymentStateHistory = $this->initResource();
        $paymentStateHistory->setState($payment->getState());
        $paymentStateHistory->setPayment($payment);
        $paymentStateHistory->setComment($payment->getComment());
        $this->createResource($paymentStateHistory);
    }
}
