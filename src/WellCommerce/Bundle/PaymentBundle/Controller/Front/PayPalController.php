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

namespace WellCommerce\Bundle\PaymentBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PayPalProcessorInterface;

/**
 * Class PayPalController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalController extends AbstractPaymentController
{
    public function confirmAction($token) : Response
    {
        $payment   = $this->manager->findPaymentByToken($token);
        $processor = $this->manager->getPaymentProcessor($payment->getProcessor());
        
        return $this->displayTemplate($processor->getConfigurator()->getName() . '_confirm', [
            'payment' => $payment
        ]);
    }
    
    public function cancelAction($token) : Response
    {
        $payment   = $this->manager->findPaymentByToken($token);
        $processor = $this->manager->getPaymentProcessor($payment->getProcessor());
        
        return $processor->cancelPayment($payment);
    }
    
    public function notifyAction($token) : Response
    {
        $payment   = $this->manager->findPaymentByToken($token);
        $processor = $this->manager->getPaymentProcessor($payment->getProcessor());
        
        return $processor->notifyPayment($payment);
    }
    
    protected function getCurrentPaymentProcessor() : PaymentProcessorInterface
    {
        return $this->manager->getPaymentProcessor('paypal');
    }
}
