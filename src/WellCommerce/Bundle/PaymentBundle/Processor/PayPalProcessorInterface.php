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

    /**
     * Returns the URL to confirm action
     *
     * @param PaymentInterface $payment
     *
     * @return string
     */
    public function getConfirmUrl(PaymentInterface $payment) : string;

    /**
     * Returns the URL to cancel action
     *
     * @param PaymentInterface $payment
     *
     * @return string
     */
    public function getCancelUrl(PaymentInterface $payment) : string;
}
