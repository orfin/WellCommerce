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
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class PayPal
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPal extends AbstractPaymentProcessor
{
    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getFieldName('clientId'),
            'label'        => $this->trans('paypal.label.client_id'),
            'dependencies' => [$dependency]
        ]));
        
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getFieldName('clientSecret'),
            'label'        => $this->trans('paypal.label.client_secret'),
            'dependencies' => [$dependency]
        ]));
        
        $fieldset->addChild($builder->getElement('select', [
            'name'         => $this->getFieldName('mode'),
            'label'        => $this->trans('paypal.label.mode'),
            'options'      => [
                'live'    => 'live',
                'sandbox' => 'sandbox'
            ],
            'dependencies' => [$dependency]
        ]));
    }
    
    /**
     * {@inheritdoc}
     */
    public function processPayment(PaymentInterface $payment) : PaymentInterface
    {
        $apiContext = $this->getApiContext($payment);
        $order      = $payment->getOrder();
        $payer      = new Payer();
        $payer->setPaymentMethod("paypal");
        
        $itemList     = $this->createItemList($order);
        $amount       = $this->createAmount($order);
        $redirectUrls = $this->createRedirectUrls();
        
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription($order->getId());
        $transaction->setInvoiceNumber(uniqid());
        
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
    
    /**
     * {@inheritdoc}
     */
    public function confirmPayment(Request $request) : PaymentInterface
    {
        $token         = $request->get('paymentId');
        $payment       = $this->paymentManager->findProcessorPaymentByToken($this->getAlias(), $token);
        $apiContext    = $this->getApiContext($payment);
        $payPalPayment = $this->getPayPalPayment($payment, $apiContext);

        if ($payPalPayment->getState() !== PaymentInterface::PAYMENT_STATE_APPROVED) {
            $execution = new PaymentExecution();
            $execution->setPayerId($request->get('PayerID'));
            $payPalPayment->execute($execution, $apiContext);
        }

        return $this->updatePayment($payment, $apiContext);
    }

    protected function updatePayment(PaymentInterface $payment, ApiContext $apiContext) : PaymentInterface
    {
        $payPalPayment = $this->getPayPalPayment($payment, $apiContext);
        $payment->setState($payPalPayment->getState());

        $this->paymentManager->updateResource($payment);

        return $payment;
    }

    protected function getPayPalPayment(PaymentInterface $payment, ApiContext $apiContext) : Payment
    {
        return Payment::get($payment->getToken(), $apiContext);
    }
    
    /**
     * {@inheritdoc}
     */
    public function cancelPayment(OrderInterface $order, Request $request) : PaymentInterface
    {
        $payment    = $order->getPayments()->first();
        $apiContext = $this->getApiContext($payment);
        $this->updatePayment($payment, $apiContext);

        return $payment;
    }
    
    /**
     * Creates an amount definition for given order
     *
     * @param OrderInterface $order
     *
     * @return Amount
     */
    protected function createAmount(OrderInterface $order) : Amount
    {
        $details = $this->createDetails($order);
        $amount  = new Amount();
        $amount->setCurrency($order->getCurrency());
        $amount->setTotal($order->getOrderTotal()->getGrossAmount());
        $amount->setDetails($details);
        
        return $amount;
    }
    
    /**
     * Creates PayPal payment details from given order
     *
     * @param OrderInterface $order
     *
     * @return Details
     */
    protected function createDetails(OrderInterface $order) : Details
    {
        $details = new Details();
        $details->setShipping($order->getShippingTotal()->getNetAmount());
        $details->setTax($order->getOrderTotal()->getTaxAmount());
        $details->setSubtotal($order->getProductTotal()->getNetAmount());
        
        return $details;
    }
    
    /**
     * Creates a collection of PayPal items for given order
     *
     * @param OrderInterface $order
     *
     * @return ItemList
     */
    protected function createItemList(OrderInterface $order) : ItemList
    {
        $itemList = new ItemList();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use ($itemList) {
            $itemList->addItem($this->createItem($orderProduct));
        });
        
        return $itemList;
    }
    
    /**
     * Creates a single PayPal item from given order product
     *
     * @param OrderProductInterface $orderProduct
     *
     * @return Item
     */
    protected function createItem(OrderProductInterface $orderProduct) : Item
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
     * Configures the PayPal API
     *
     * @param PaymentInterface $payment
     *
     * @return ApiContext
     */
    protected function getApiContext(PaymentInterface $payment) : ApiContext
    {
        $configuration = $payment->getConfiguration();
        
        PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = 6;
        
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $configuration['paypal_clientId'],
                $configuration['paypal_clientSecret']
            )
        );
        
        $apiContext->setConfig([
            'mode'            => $configuration['paypal_mode'],
            'log.LogEnabled'  => true,
            'log.FileName'    => $this->getKernel()->getLogDir() . '/PayPal.log',
            'log.LogLevel'    => 'DEBUG',
            'cache.enabled'   => true,
            'http.VerifyPeer' => 0,
            'http.VerifyHost' => 2,
        ]);
        
        return $apiContext;
    }
}
