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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Interface PaymentGatewayInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentGatewayInterface
{
    public function initializePayment(PaymentInterface $payment);

    public function executePayment(PaymentInterface $payment, Request $request);

    public function confirmPayment(PaymentInterface $payment, Request $request);

    public function cancelPayment(PaymentInterface $payment, Request $request);

    public function notifyPayment(PaymentInterface $payment, Request $request);
}
