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

use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Core\PayPalHttpConfig;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class PayPalGateway
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PayPalGateway implements PayPalGatewayInterface
{
    /**
     * @var array
     */
    private $options;
    
    /**
     * @var RouterHelperInterface
     */
    private $routerHelper;
    
    /**
     * PayPalGateway constructor.
     *
     * @param array                 $options
     * @param RouterHelperInterface $routerHelper
     */
    public function __construct(array $options = [], RouterHelperInterface $routerHelper)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options      = $resolver->resolve($options);
        $this->routerHelper = $routerHelper;
    }
    
    public function initializePayment(PaymentInterface $payment)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        $payPalType    = $configuration['paypal_type'];
        
        if ($payPalType === 'paypal') {
            $apiContext   = $this->getApiContext($configuration);
            $payer        = $this->createPayer($payPalType);
            $redirectUrls = $this->createRedirectUrls($payment);
            $transaction  = $this->createTransaction($order);
            
            $payPalPayment = new Payment();
            $payPalPayment->setIntent("sale");
            $payPalPayment->setPayer($payer);
            $payPalPayment->setRedirectUrls($redirectUrls);
            $payPalPayment->setTransactions([$transaction]);
            
            try {
                $payPalPayment->create($apiContext);
            } catch (PayPalConnectionException $e) {
                throw $e;
            }
            
            $payment->setRedirectUrl($payPalPayment->getApprovalLink());
            $payment->setState($payPalPayment->getState());
            $payment->setExternalIdentifier($payPalPayment->getId());
        }
        
        return $payment;
    }
    
    public function executePayment(PaymentInterface $payment, Request $request)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        $apiContext    = $this->getApiContext($configuration);
        $ccFirstname   = $request->request->get('firstname');
        $ccLastname    = $request->request->get('lastname');
        $ccNumber      = str_replace(' ', '', $request->request->get('number'));
        $ccExpiry      = $request->request->get('expiry');
        $ccCvc         = $request->request->get('cvc');
        
        if (strlen($ccExpiry) == 0 || strlen($ccExpiry) < 5) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Upsss! Wygląda na to, że data ważności karty wpisana jest nieprawidłowo. Prosimy wprowadź ją w formacie MM/YY'
            ]);
        }
        
        list($ccExpiryMonth, $ccExpiryYear) = explode('/', $ccExpiry);
        if (substr($ccExpiryMonth, 0, 1) == 0) {
            $ccExpiryMonth = substr($ccExpiryMonth, 1, 1);
        }
        
        $ccExpiryYear = '20' . $ccExpiryYear;
        $cardType     = $this->cardType($ccNumber);
        
        if (strlen($ccExpiryMonth) == 0 || strlen($ccExpiryYear) < 4) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Upsss! Wygląda na to, że data ważności karty wpisana jest nieprawidłowo. Prosimy wprowadź ją w formacie MM/YY'
            ]);
        }
        
        if ('' == $cardType) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Upsss! Wygląda na to, że wpisany numer karty jest nieprawidłowy. Prosimy wprowadź numer ponownie.'
            ]);
        }
        
        $card = new CreditCard();
        $card->setType($cardType);
        $card->setNumber($ccNumber);
        $card->setExpireMonth($ccExpiryMonth);
        $card->setExpireYear($ccExpiryYear);
        $card->setCvv2($ccCvc);
        $card->setFirstName($ccFirstname);
        $card->setLastName($ccLastname);
        $card->setBillingAddress($this->createAddress($order));
        
        $fundingInstrument = new FundingInstrument();
        $fundingInstrument->setCreditCard($card);
        
        $payer = $this->createPayer($configuration['paypal_type']);
        $payer->setFundingInstruments([$fundingInstrument]);
        
        $amount      = $this->createAmount($order);
        $transaction = $this->createTransaction($order);
        
        $payPalPayment = new Payment();
        $payPalPayment->setIntent("sale");
        $payPalPayment->setPayer($payer);
        $payPalPayment->setTransactions([$transaction]);
        
        try {
            $payPalPayment->create($apiContext);
        } catch (PayPalConnectionException $e) {
            $error_object = json_decode($e->getData());
            $message      = 'Upsss! Wystąpił nieoczekiwany błąd w trakcie przetwarzania transakcji. Skontaktuj się z obsługą sklepu.';
            switch ($error_object->name) {
                case 'CREDIT_CARD_CVV_CHECK_FAILED':
                case 'MISSING_CVV2':
                case 'GATEWAY_DECLINE_CVV2':
                    $message = 'Upsss! Wygląda na to, że podany przez Ciebie kod CVV2 lub CVC2 jest nieprawidłowy lub niepełny. Prosimy sprawdź numer i wprowadź go ponownie.';
                    break;
                case 'CREDIT_CARD_REFUSED':
                    $message = 'Upsss! Wygląda na to, że twój bank nie autoryzował transakcji. Prosimy spróbuj zapłacić przy użyciu innej karty.';
                    break;
                case 'EXPIRED_CREDIT_CARD':
                    $message = 'Upsss! Wygląda na to, że upłynął termin ważności twojej karty. Prosimy spróbuj zapłacić przy użyciu innej karty.';
                    break;
                case 'PAYER_EMPTY_BILLING_ADDRESS':
                    $message = 'Upsss! Wygląda na to, że podałeś niepełne dane adresowe. Prosimy sprawdź swoje dane adresowe i spróbuje ponowić płatność.';
                    break;
                case 'INVALID_CC_NUMBER':
                    $message = 'Upsss! Wygląda na to, że wpisany numer karty jest nieprawidłowy. Prosimy wprowadź numer ponownie.';
                    break;
                case 'CC_TYPE_NOT_SUPPORTED':
                    $message = 'Upsss! Nasz system nie obsługuje płatności dokonywanych tego typu kartą. Prosimy spróbuj użyć innej karty lub zmień metodę płatności na Paypal lub przelew bankowy.';
                    break;
                case 'VALIDATION_ERROR':
                    $message = 'Upsss! Podałeś niepoprawne dane karty. Spróbuj ponownie.';
                    break;
            }
            
            return new JsonResponse([
                'success' => false,
                'message' => $message
            ]);
        }
        
        $payment->setExternalIdentifier($payPalPayment->getId());
        
        if ($payment->getState() == 'approved') {
            $payment->setState(PaymentInterface::PAYMENT_STATE_APPROVED);
            
            return new JsonResponse([
                'success' => true,
                'message' => 'Płatność zakończona sukcesem',
            ]);
        }
        
        return new JsonResponse([
            'success' => false,
            'message' => 'Wystąpił nieoczekiwany błąd. Skontaktuj się z obsługą sklepu'
        ]);
    }
    
    public function confirmPayment(PaymentInterface $payment, Request $request)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        $paymentId     = $request->get('paymentId');
        $payerId       = $request->get('PayerID');
        $apiContext    = $this->getApiContext($configuration);
        
        if ($payment->getExternalIdentifier() === $paymentId && false === $payment->isApproved()) {
            $payPalPayment = Payment::get($paymentId, $apiContext);
            $execution     = new PaymentExecution();
            $execution->setPayerId($payerId);
            $payPalPayment->execute($execution, $apiContext);
            
            $payment->setState(PaymentInterface::PAYMENT_STATE_APPROVED);
        }
    }
    
    public function cancelPayment(PaymentInterface $payment, Request $request)
    {
        // TODO: Implement cancelPayment() method.
    }
    
    public function notifyPayment(PaymentInterface $payment, Request $request)
    {
        // TODO: Implement notifyPayment() method.
    }
    
    private function createRedirectUrls(PaymentInterface $payment) : RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->routerHelper->generateUrl('front.payment.confirm', ['token' => $payment->getToken()]));
        $redirectUrls->setCancelUrl($this->routerHelper->generateUrl('front.payment.cancel', ['token' => $payment->getToken()]));
        
        return $redirectUrls;
    }
    
    private function createPayer(string $paymentMethod) : Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod($paymentMethod);
        
        return $payer;
    }
    
    private function createTransaction(OrderInterface $order) : Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->createAmount($order));
        $transaction->setItemList($this->createItemList($order));
        $transaction->setDescription($order->getId());
        
        return $transaction;
    }
    
    private function createAmount(OrderInterface $order) : Amount
    {
        $details = $this->createDetails($order);
        $amount  = new Amount();
        $amount->setCurrency($order->getCurrency());
        $amount->setTotal($order->getSummary()->getGrossAmount());
        $amount->setDetails($details);
        
        return $amount;
    }
    
    private function createDetails(OrderInterface $order) : Details
    {
        $shippingCosts = $order->getModifier('shipping_cost');
        $details       = new Details();
        $details->setShipping($shippingCosts->getNetAmount());
        $details->setTax($order->getSummary()->getTaxAmount());
        $details->setSubtotal($order->getProductTotal()->getNetPrice());
        
        return $details;
    }
    
    private function createItemList(OrderInterface $order) : ItemList
    {
        $itemList = new ItemList();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use ($itemList) {
            $itemList->addItem($this->createItem($orderProduct));
        });
        
        return $itemList;
    }
    
    private function createItem(OrderProductInterface $orderProduct) : Item
    {
        $item = new Item();
        $item->setName($orderProduct->getProduct()->translate()->getName());
        $item->setCurrency($orderProduct->getSellPrice()->getCurrency());
        $item->setQuantity($orderProduct->getQuantity());
        $item->setSku($orderProduct->getProduct()->getSku());
        $item->setPrice($orderProduct->getSellPrice()->getNetAmount());
        $item->setTax($orderProduct->getSellPrice()->getTaxAmount());
        
        return $item;
    }
    
    private function createAddress(OrderInterface $order) : Address
    {
        $address = new Address();
        $address->setLine1($order->getBillingAddress()->getLine1());
        $address->setLine2($order->getBillingAddress()->getLine2());
        $address->setCity($order->getBillingAddress()->getCity());
        $address->setPostalCode($order->getBillingAddress()->getPostalCode());
        $address->setCountryCode($order->getBillingAddress()->getCountry());
        
        return $address;
    }
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'log.LogEnabled',
            'log.FileName',
            'log.LogLevel',
            'cache.enabled',
            'http.VerifyPeer',
            'http.VerifyHost',
        ]);
        
        $resolver->setDefaults([
            'log.LogEnabled'  => true,
            'log.LogLevel'    => 'DEBUG',
            'cache.enabled'   => true,
            'http.VerifyPeer' => 0,
            'http.VerifyHost' => 2,
        ]);
        
        $resolver->setAllowedTypes('log.LogEnabled', 'bool');
        $resolver->setAllowedTypes('log.LogLevel', 'string');
        $resolver->setAllowedTypes('cache.enabled', 'bool');
        $resolver->setAllowedTypes('http.VerifyPeer', 'int');
        $resolver->setAllowedTypes('http.VerifyHost', 'int');
    }
    
    private function getApiContext(array $configuration) : ApiContext
    {
        PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = 6;
        
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $configuration['paypal_client_id'],
                $configuration['paypal_client_secret']
            )
        );
        
        $apiContext->setConfig([
            'mode'            => $configuration['paypal_mode'],
            'log.LogEnabled'  => $this->options['log.LogEnabled'],
            'log.FileName'    => $this->options['log.FileName'],
            'log.LogLevel'    => $this->options['log.LogLevel'],
            'cache.enabled'   => $this->options['cache.enabled'],
            'http.VerifyPeer' => $this->options['http.VerifyPeer'],
            'http.VerifyHost' => $this->options['http.VerifyHost'],
        ]);
        
        return $apiContext;
    }
    
    private function cardType(string $number) : string
    {
        $number = preg_replace('/[^\d]/', '', $number);
        
        if (preg_match('/^3[47][0-9]{13}$/', $number)) {
            return 'amex';
        } elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number)) {
            return 'discover';
        } elseif (preg_match('/^5[1-5][0-9]{14}$/', $number)) {
            return 'mastercard';
        } elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number)) {
            return 'visa';
        } else {
            return '';
        }
    }
}
