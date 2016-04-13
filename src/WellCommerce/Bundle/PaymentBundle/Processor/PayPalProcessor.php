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

use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PayPal
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalProcessor extends AbstractPayPalProcessor
{
    /**
     * {@inheritdoc}
     */
    public function preparePayment(PaymentInterface $payment)
    {
        $order = $payment->getOrder();
    }
    
    /**
     * {@inheritdoc}
     */
    public function processPayment(PaymentInterface $payment) : PaymentInterface
    {
        $order = $payment->getOrder();
        
        $payer        = $this->createPayer('paypal');
        $redirectUrls = $this->createRedirectUrls($payment);
        $transaction  = $this->createTransaction($order);
        
        $payPalPayment = new Payment();
        $payPalPayment->setIntent("sale");
        $payPalPayment->setPayer($payer);
        $payPalPayment->setRedirectUrls($redirectUrls);
        $payPalPayment->setTransactions([$transaction]);
        
        try {
            $payPalPayment->create($apiContext);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        
        $payment->setApprovalUrl($payPalPayment->getApprovalLink());
        $payment->setState($payPalPayment->getState());
        $payment->setToken($payPalPayment->getId());
        
        $this->paymentManager->updateResource($payment);
        
        return $payment;
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function confirmPayment(PaymentInterface $payment)
//    {
//        $token         = $request->get('paymentId');
//        $payment       = $this->paymentManager->findProcessorPaymentByToken($this->getAlias(), $token);
//        $apiContext    = $this->getApiContext($payment);
//        $payPalPayment = $this->getPayPalPayment($payment, $apiContext);
//
//        if ($payPalPayment->getState() !== PaymentInterface::PAYMENT_STATE_APPROVED) {
//            $execution = new PaymentExecution();
//            $execution->setPayerId($request->get('PayerID'));
//            $payPalPayment->execute($execution, $apiContext);
//        }
//
//        return $this->updatePayment($payment, $apiContext);
//    }
    
    protected function updatePayment(PaymentInterface $payment, ApiContext $apiContext) : PaymentInterface
    {
        $payPalPayment = $this->getPayPalPayment($payment, $apiContext);
        $payment->setState($payPalPayment->getState());
        
        $this->paymentManager->updateResource($payment);
        
        return $payment;
    }
    
    /**
     * Creates a collection of PayPal url definitions
     *
     * @return RedirectUrls
     */
    protected function createRedirectUrls(PaymentInterface $payment) : RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->getConfirmUrl($payment));
        $redirectUrls->setCancelUrl($this->getCancelUrl($payment));
        
        return $redirectUrls;
    }
    
    /**
     * {@inheritdoc}
     */
    public function confirmPayment(PaymentInterface $payment) : Response
    {
        return $this->getRouterHelper()->redirectTo('front.home_page.index');
    }
    
    /**
     * {@inheritdoc}
     */
    public function cancelPayment(PaymentInterface $payment) : Response
    {
        return $this->getRouterHelper()->redirectTo('front.home_page.index');
    }
    
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
