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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\PaymentManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class PaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentController extends AbstractFrontController
{
    public function initializeAction(string $token)
    {
        $payment   = $this->getManager()->findPaymentByToken($token);
        $order     = $payment->getOrder();
        $processor = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
        
        $processor->getGateway()->initializePayment($payment);
        
        $this->getManager()->updateResource($payment);
        
        $content = $this->renderView($processor->getConfigurator()->getInitializeTemplateName(), [
            'payment'       => $payment,
            'configuration' => $order->getPaymentMethod()->getConfiguration(),
        ]);
        
        return new Response($content);
    }
    
    public function confirmAction(string $token, Request $request)
    {
        $payment   = $this->getManager()->findPaymentByToken($token);
        $order     = $payment->getOrder();
        $processor = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
        
        $processor->getGateway()->confirmPayment($payment, $request);
        
        $this->getManager()->updateResource($payment);
        
        if ($payment->getState() === PaymentInterface::PAYMENT_STATE_APPROVED) {
            $order->setCurrentStatus($order->getPaymentMethod()->getPaymentSuccessOrderStatus());
            $this->getDoctrineHelper()->getEntityManager()->flush();
        }
        
        return $this->displayTemplate('confirm', [
            'payment'       => $payment,
            'configuration' => $order->getPaymentMethod()->getConfiguration(),
        ]);
    }
    
    public function cancelAction(string $token)
    {
        
    }
    
    public function executeAction(string $token, Request $request)
    {
        $payment   = $this->getManager()->findPaymentByToken($token);
        $order     = $payment->getOrder();
        $processor = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
        $response  = $processor->getGateway()->executePayment($payment, $request);
        
        $this->getManager()->updateResource($payment);
        
        return $response;
    }
    
    public function notifyAction(string $token, Request $request)
    {
        $payment   = $this->getManager()->findPaymentByToken($token);
        $order     = $payment->getOrder();
        $processor = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
        $response  = $processor->getGateway()->notifyPayment($payment, $request);
        
        $this->getManager()->updateResource($payment);
        
        if ($payment->getState() === PaymentInterface::PAYMENT_STATE_APPROVED) {
            $order->setCurrentStatus($order->getPaymentMethod()->getPaymentSuccessOrderStatus());
            $this->getEntityManager()->flush();
        }
        
        return $response;
    }
    
    protected function getManager() : PaymentManagerInterface
    {
        return parent::getManager();
    }
    
    private function getPaymentProcessor(string $name) : PaymentProcessorInterface
    {
        return $this->get('payment.processor.collection')->get($name);
    }
}
