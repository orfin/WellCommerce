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

use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PayPalProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalProcessor extends AbstractPaymentProcessor
{
    /**
     * {@inheritdoc}
     */
    public function getInitializeUrl() : string
    {
        return $this->getRouterHelper()->generateUrl('front.paypal.initialize');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfirmUrl(PaymentInterface $payment) : string
    {
        return $this->getRouterHelper()->generateUrl('front.paypal.confirm', ['token' => $payment->getToken()]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCancelUrl(PaymentInterface $payment) : string
    {
        return $this->getRouterHelper()->generateUrl('front.paypal.cancel', ['token' => $payment->getToken()]);
    }
}
