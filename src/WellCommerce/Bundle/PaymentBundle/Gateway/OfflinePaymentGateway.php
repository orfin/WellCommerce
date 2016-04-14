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
class OfflinePaymentGateway implements PaymentGatewayInterface
{
    /**
     * {@inheritdoc}
     */
    public function executePayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
    }

    /**
     * {@inheritdoc}
     */
    public function confirmPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_APPROVED);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_CANCELLED);
    }

    /**
     * {@inheritdoc}
     */
    public function notifyPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::PAYMENT_STATE_PENDING);
    }
}
