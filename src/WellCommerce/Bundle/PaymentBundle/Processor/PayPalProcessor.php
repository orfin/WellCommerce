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

use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\PaymentBundle\Configurator\PaymentMethodConfiguratorInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Gateway\PayPalGatewayInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;

/**
 * Class PayPal
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalProcessor extends AbstractPaymentProcessor implements PayPalProcessorInterface
{
    /**
     * @var PayPalGatewayInterface
     */
    protected $gateway;
    
    /**
     * PayPalProcessor constructor.
     *
     * @param PaymentMethodConfiguratorInterface $configurator
     * @param PaymentManagerInterface            $paymentManager
     * @param PayPalGatewayInterface             $gateway
     */
    public function __construct(
        PaymentMethodConfiguratorInterface $configurator,
        PaymentManagerInterface $paymentManager,
        PayPalGatewayInterface $gateway
    ) {
        parent::__construct($configurator, $paymentManager);
        $this->gateway = $gateway;
    }
    
    /**
     * {@inheritdoc}
     */
    public function processPayment(PaymentInterface $payment) : PaymentInterface
    {
        $order = $payment->getOrder();
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        
        $itemList     = $this->createItemList($order);
        $amount       = $this->createAmount($order);
        $redirectUrls = $this->createRedirectUrls();
        
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription($order->getId());
        
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
    protected function createRedirectUrls() : RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->getConfirmUrl());
        $redirectUrls->setCancelUrl($this->getCancelUrl());
        
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
    public function notifyPayment(PaymentInterface $payment) : Response
    {
        return $this->getRouterHelper()->redirectTo('front.home_page.index');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmUrl(string $token) : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.confirm', ['token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCancelUrl(string $token) : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.cancel', ['token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyUrl(string $token) : string
    {
        return $this->getRouterHelper()->generateUrl('front.payment.notify', ['token' => $token]);
    }
}
