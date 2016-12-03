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

use OpenPayU_Configuration;
use OpenPayU_Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PayUGateway
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PayUGateway implements PaymentGatewayInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    private $currencyHelper;
    
    /**
     * @var RouterHelperInterface
     */
    private $routerHelper;
    
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;
    
    /**
     * PayUGateway constructor.
     *
     * @param CurrencyHelperInterface $currencyHelper
     * @param RouterHelperInterface   $routerHelper
     * @param RequestHelperInterface  $requestHelper
     */
    public function __construct (
        CurrencyHelperInterface $currencyHelper,
        RouterHelperInterface $routerHelper,
        RequestHelperInterface $requestHelper
    ) {
        $this->currencyHelper = $currencyHelper;
        $this->routerHelper   = $routerHelper;
        $this->requestHelper  = $requestHelper;
    }
    
    public function initializePayment (PaymentInterface $payment)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        
        $amount          = $this->calculateOrderPaymentAmount($order);
        $contactDetails  = $order->getContactDetails();
        $transIdentifier = $this->generateOrderTransactionId($order);
        
        OpenPayU_Configuration::setEnvironment('secure');
        OpenPayU_Configuration::setMerchantPosId($configuration['payu_merchant_pos_id']);
        OpenPayU_Configuration::setSignatureKey($configuration['payu_signature_key']);
        
        $trans                          = [];
        $trans['notifyUrl']             = $this->routerHelper->generateUrl('front.payment.notify', ['token' => $payment->getToken()]);
        $trans['continueUrl']           = $this->routerHelper->generateUrl('front.payment.confirm', ['token' => $payment->getToken()]);
        $trans['customerIp']            = $this->requestHelper->getCurrentRequest()->getClientIp();
        $trans['merchantPosId']         = OpenPayU_Configuration::getMerchantPosId();
        $trans['description']           = 'Zamówienie ' . $order->getNumber();
        $trans['additionalDescription'] = $order->getNumber();
        $trans['currencyCode']          = 'PLN';
        $trans['totalAmount']           = $amount;
        $trans['extOrderId']            = $transIdentifier;
        $trans['products']              = [];
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$trans) {
            $trans['products'][] = [
                'name'      => $orderProduct->getProduct()->translate()->getName(),
                'unitPrice' => round($orderProduct->getSellPrice()->getGrossAmount() * 100, 0),
                'quantity'  => $orderProduct->getQuantity(),
            ];
        });
        
        $trans['buyer']['email']     = $contactDetails->getEmail();
        $trans['buyer']['phone']     = $contactDetails->getPhone();
        $trans['buyer']['firstName'] = $contactDetails->getFirstName();
        $trans['buyer']['lastName']  = $contactDetails->getLastName();
        
        /** @var OpenPayU_Order $response */
        $response = OpenPayU_Order::create($trans);
        
        $payment->setRedirectUrl($response->getResponse()->redirectUri);
        $payment->setExternalIdentifier($response->getResponse()->orderId);
        $payment->setInProgress();
        
        return $payment;
    }
    
    public function executePayment (PaymentInterface $payment, Request $request)
    {
    }
    
    public function confirmPayment (PaymentInterface $payment, Request $request)
    {
    }
    
    private function generateOrderTransactionId (OrderInterface $order) : string
    {
        return sha1($order->getId() . '-' . time());
    }
    
    private function calculateOrderPaymentAmount (OrderInterface $order) : int
    {
        $finalPrice = $order->getSummary()->getGrossAmount();
        $amount     = round($finalPrice * 100, 0);
        
        return (int)$amount;
    }
    
    public function cancelPayment (PaymentInterface $payment, Request $request)
    {
    }
    
    public function notifyPayment (PaymentInterface $payment, Request $request)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        
        OpenPayU_Configuration::setEnvironment('secure');
        OpenPayU_Configuration::setMerchantPosId($configuration['payu_merchant_pos_id']);
        OpenPayU_Configuration::setSignatureKey($configuration['payu_signature_key']);
        
        $body = file_get_contents('php://input');
        $data = trim($body);
        
        try {
            if (!empty($data)) {
                $result                = OpenPayU_Order::consumeNotification($data);
                $transactionIdentifier = $result->getResponse()->order->extOrderId;
                $transactionStatus     = $result->getResponse()->order->status;
                $payUOrder             = OpenPayU_Order::retrieve($result->getResponse()->order->orderId);
                
                if ($payUOrder->getStatus() == 'SUCCESS' && $transactionStatus == 'COMPLETED') {
                    $payment->setApproved();
                    
                    return new Response($transactionIdentifier);
                }
            }
            
        } catch (\OpenPayU_Exception $e) {
            return new Response($e->getMessage(), 500);
        }
        
        return new Response('Brak danych', 500);
    }
}
