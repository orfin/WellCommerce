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
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PayPalProcessorInterface;

/**
 * Class PaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentController extends AbstractFrontController
{
    /**
     * @var PaymentManagerInterface
     */
    protected $manager;
    
    public function initializeAction() : Response
    {
        if ($this->manager->getOrderContext()->hasCurrentOrder()) {
            $order     = $this->manager->getOrderContext()->getCurrentOrder();
            $processor = $this->manager->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
            
            if ('paypal' !== $processor->getConfigurator()->getName()) {
                return $this->redirectResponse($processor->getInitializeUrl());
            }
            
            $payment = $this->manager->getFirstPaymentForOrder($order);
            
            return $this->displayTemplate('index', [
                'payment' => $payment
            ]);
        }
        
        return $this->redirectToRoute('front.home_page.index');
    }
    
    public function confirmAction($token) : Response
    {
        $payment   = $this->manager->findPaymentByToken($token);
        $processor = $this->manager->getPaymentProcessor($payment->getProcessor());
        
        return $this->displayTemplate($processor->getConfigurator()->getName() . '_confirm', [
            'payment' => $payment
        ]);
        
        return $processor->confirmPayment($payment);
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
    
    protected function getProcessor() : PayPalProcessorInterface
    {
        return $this->manager->getPaymentProcessor('paypal');
    }
}
