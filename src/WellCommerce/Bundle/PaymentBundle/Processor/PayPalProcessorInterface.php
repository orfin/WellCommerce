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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Interface PaymentProcessorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PayPalProcessorInterface extends PaymentProcessorInterface
{
    /**
     * Creates a payment for order
     *
     * @param PaymentInterface $payment
     */
    public function preparePayment(PaymentInterface $payment);

    /**
     * Confirms a payment for order
     *
     * @param PaymentInterface $payment
     *
     * @return Response
     */
    public function confirmPayment(PaymentInterface $payment) : Response;

    /**
     * Cancels a payment for order
     *
     * @param PaymentInterface $payment
     *
     * @return Response
     */
    public function cancelPayment(PaymentInterface $payment) : Response;
}
