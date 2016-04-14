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
 * Interface PaymentGatewayInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentGatewayInterface
{
    public function executePayment(PaymentInterface $payment);

    public function confirmPayment(PaymentInterface $payment);

    public function cancelPayment(PaymentInterface $payment);

    public function notifyPayment(PaymentInterface $payment);
}
