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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Client\Przelewy24;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class Przelewy24Gateway
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Przelewy24Gateway implements PaymentGatewayInterface
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
        $order           = $payment->getOrder();
        $paymentMethod   = $order->getPaymentMethod();
        $configuration   = $paymentMethod->getConfiguration();
        $amount          = $this->calculateOrderPaymentAmount($order);
        $contactDetails  = $order->getContactDetails();
        $transIdentifier = $this->generateOrderTransactionId($order);
        $billingAddress  = $order->getBillingAddress();
        $przelewy24      = $this->createClient($payment);
        
        $parameters = [
            'p24_merchant_id' => $configuration['przelewy24_merchant_id'],
            'p24_pos_id'      => $configuration['przelewy24_pos_id'],
            'p24_session_id'  => $transIdentifier,
            'p24_amount'      => $amount,
            'p24_currency'    => $order->getCurrency(),
            'p24_description' => $order->getNumber(),
            'p24_email'       => trim($contactDetails->getEmail()),
            'p24_client'      => sprintf('%s %s', $billingAddress->getFirstName(), $billingAddress->getLastName()),
            'p24_address'     => $billingAddress->getLine1(),
            'p24_zip'         => $billingAddress->getPostalCode(),
            'p24_city'        => $billingAddress->getCity(),
            'p24_country'     => $billingAddress->getCountry(),
            'p24_phone'       => $contactDetails->getPhone(),
            'p24_language'    => 'pl',
            'p24_url_return'  => $this->routerHelper->generateUrl('front.payment.confirm', ['token' => $payment->getToken()]),
            'p24_url_status'  => $this->routerHelper->generateUrl('front.payment.notify', ['token' => $payment->getToken()]),
            'p24_time_limit'  => 30,
            'p24_api_version' => Przelewy24::VERSION,
            'p24_encoding'    => 'UTF-8',
        ];
        
        foreach ($parameters as $parameterName => $parameterValue) {
            $przelewy24->addValue($parameterName, $parameterValue);
        }
        
        $result = $przelewy24->trnRegister(false);
        
        if (isset($result['token'])) {
            $payment->setRedirectUrl($przelewy24->getHost() . "trnRequest/" . $result['token']);
            $payment->setExternalToken($result['token']);
            $payment->setInProgress();
        }
    }
    
    public function executePayment (PaymentInterface $payment, Request $request)
    {
    }
    
    public function confirmPayment (PaymentInterface $payment, Request $request)
    {
    }
    
    public function cancelPayment (PaymentInterface $payment, Request $request)
    {
        $payment->setCancelled();
    }
    
    public function notifyPayment (PaymentInterface $payment, Request $request)
    {
        $order      = $payment->getOrder();
        $amount     = $this->calculateOrderPaymentAmount($order);
        $przelewy24 = $this->createClient($payment);
        $parameters = $_POST;
        
        foreach ($parameters as $parameterName => $parameterValue) {
            $przelewy24->addValue($parameterName, $parameterValue);
        }
        
        $przelewy24->addValue('p24_currency', $order->getCurrency());
        $przelewy24->addValue('p24_amount', $amount);
        $result = $przelewy24->trnVerify();
        
        if (isset($result['error']) and $result["error"] === '0') {
            $payment->setApproved();
        } else {
            $payment->setFailed();
        }
    }
    
    private function createClient (PaymentInterface $payment) : Przelewy24
    {
        $method        = $payment->getOrder()->getPaymentMethod();
        $configuration = $method->getConfiguration();
        
        return new Przelewy24(
            $configuration['przelewy24_merchant_id'],
            $configuration['przelewy24_pos_id'],
            $configuration['przelewy24_crc'],
            $configuration['przelewy24_test_mode']
        );
    }
    
    private function calculateOrderPaymentAmount (OrderInterface $order) : int
    {
        $finalPrice = $order->getSummary()->getGrossAmount();
        $amount     = round($finalPrice * 100, 0);
        
        return (int)$amount;
    }
    
    private function generateOrderTransactionId (OrderInterface $order) : string
    {
        return sha1($order->getId() . '-' . time());
    }
}
