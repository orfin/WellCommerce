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
    
    public function initializeAction (PaymentInterface $payment)
    {
        $order     = $payment->getOrder();
        $processor = $this->manager->getPaymentProcessor($order);
        
        if (!$payment->isInProgress()) {
            $processor->getGateway()->initializePayment($payment);
            $this->manager->updatePaymentState($payment);
        }
        
        if ($payment->isInProgress()) {
            return new Response($this->renderView($processor->getConfigurator()->getInitializeTemplateName(), [
                'payment' => $payment,
            ]));
        }
        
        return $this->redirectToAction('cancel', [
            'token' => $payment->getToken(),
        ]);
    }
    
    public function confirmAction (PaymentInterface $payment, Request $request)
    {
        if (!$payment->isApproved()) {
            $order     = $payment->getOrder();
            $processor = $this->manager->getPaymentProcessor($order);
            $processor->getGateway()->confirmPayment($payment, $request);
            $this->manager->updatePaymentState($payment);
        }
        
        return $this->displayTemplate('confirm', [
            'payment' => $payment,
        ]);
    }
    
    public function cancelAction (PaymentInterface $payment, Request $request)
    {
        if (!$payment->isCancelled()) {
            $order     = $payment->getOrder();
            $processor = $this->manager->getPaymentProcessor($order);
            $processor->getGateway()->cancelPayment($payment, $request);
            $this->manager->updatePaymentState($payment);
        }
        
        return $this->displayTemplate('cancel', [
            'payment' => $payment,
        ]);
    }
    
    public function executeAction (PaymentInterface $payment, Request $request)
    {
    }
    
    public function notifyAction (PaymentInterface $payment, Request $request)
    {
        if (!$payment->isApproved()) {
            $order     = $payment->getOrder();
            $processor = $this->manager->getPaymentProcessor($order);
            $processor->getGateway()->notifyPayment($payment, $request);
            $this->manager->updatePaymentState($payment);
        }
        
        return new Response('OK');
    }
}
