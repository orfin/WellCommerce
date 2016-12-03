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

use PayPal\Api\Amount;
use PayPal\Api\Details;
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
final class PayPalGateway implements PaymentGatewayInterface
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
    public function __construct (array $options = [], RouterHelperInterface $routerHelper)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options      = $resolver->resolve($options);
        $this->routerHelper = $routerHelper;
    }
    
    public function initializePayment (PaymentInterface $payment)
    {
        $order         = $payment->getOrder();
        $paymentMethod = $order->getPaymentMethod();
        $configuration = $paymentMethod->getConfiguration();
        $apiContext    = $this->getApiContext($configuration);
        $payer         = $this->createPayer();
        $redirectUrls  = $this->createRedirectUrls($payment);
        $transaction   = $this->createTransaction($order);
        
        $payPalPayment = new Payment();
        $payPalPayment->setIntent("sale");
        $payPalPayment->setPayer($payer);
        $payPalPayment->setRedirectUrls($redirectUrls);
        $payPalPayment->setTransactions([$transaction]);
        
        try {
            $payPalPayment->create($apiContext);
            $payment->setRedirectUrl($payPalPayment->getApprovalLink());
            $payment->setExternalIdentifier($payPalPayment->getId());
            $payment->setInProgress();
        } catch (PayPalConnectionException $e) {
        }
    }
    
    public function executePayment (PaymentInterface $payment, Request $request)
    {
    }
    
    public function confirmPayment (PaymentInterface $payment, Request $request)
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
            $payment->setApproved();
        } else {
            $payment->setFailed();
        }
    }
    
    public function cancelPayment (PaymentInterface $payment, Request $request)
    {
        $payment->setCancelled();
    }
    
    public function notifyPayment (PaymentInterface $payment, Request $request)
    {
    }
    
    private function createRedirectUrls (PaymentInterface $payment) : RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->routerHelper->generateUrl('front.payment.confirm', ['token' => $payment->getToken()]));
        $redirectUrls->setCancelUrl($this->routerHelper->generateUrl('front.payment.cancel', ['token' => $payment->getToken()]));
        
        return $redirectUrls;
    }
    
    private function createPayer () : Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        
        return $payer;
    }
    
    private function createTransaction (OrderInterface $order) : Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->createAmount($order));
        $transaction->setItemList($this->createItemList($order));
        $transaction->setDescription($order->getId());
        
        return $transaction;
    }
    
    private function createAmount (OrderInterface $order) : Amount
    {
        $details = $this->createDetails($order);
        $amount  = new Amount();
        $amount->setCurrency($order->getCurrency());
        $amount->setTotal($order->getSummary()->getGrossAmount());
        $amount->setDetails($details);
        
        return $amount;
    }
    
    private function createDetails (OrderInterface $order) : Details
    {
        $shippingCosts = $order->getModifier('shipping_cost');
        $details       = new Details();
        $details->setShipping($shippingCosts->getNetAmount());
        $details->setTax($order->getSummary()->getTaxAmount());
        $details->setSubtotal($order->getProductTotal()->getNetPrice());
        
        return $details;
    }
    
    private function createItemList (OrderInterface $order) : ItemList
    {
        $itemList = new ItemList();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use ($itemList) {
            $itemList->addItem($this->createItem($orderProduct));
        });
        
        return $itemList;
    }
    
    private function createItem (OrderProductInterface $orderProduct) : Item
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
    
    private function configureOptions (OptionsResolver $resolver)
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
            'cache.enabled'   => false,
            'http.VerifyPeer' => 0,
            'http.VerifyHost' => 2,
        ]);
        
        $resolver->setAllowedTypes('log.LogEnabled', 'bool');
        $resolver->setAllowedTypes('log.LogLevel', 'string');
        $resolver->setAllowedTypes('cache.enabled', 'bool');
        $resolver->setAllowedTypes('http.VerifyPeer', 'int');
        $resolver->setAllowedTypes('http.VerifyHost', 'int');
    }
    
    private function getApiContext (array $configuration) : ApiContext
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
}
