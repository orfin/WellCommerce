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

namespace WellCommerce\Bundle\PaymentBundle\Gateway;

use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class OfflinePaymentGateway
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OfflinePaymentGateway implements PaymentGatewayInterface
{
    public function executePayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
    }

    public function confirmPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_APPROVED);
    }

    public function cancelPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_CANCELLED);
    }

    public function notifyPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_PENDING);
    }
}
