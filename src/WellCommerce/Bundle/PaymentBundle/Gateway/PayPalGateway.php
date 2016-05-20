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

use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Core\PayPalHttpConfig;
use PayPal\Rest\ApiContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
     * PayPalGateway constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function executePayment(PaymentInterface $payment)
    {
        // TODO: Implement executePayment() method.
    }

    public function confirmPayment(PaymentInterface $payment)
    {
        // TODO: Implement confirmPayment() method.
    }

    public function cancelPayment(PaymentInterface $payment)
    {
        // TODO: Implement cancelPayment() method.
    }

    public function notifyPayment(PaymentInterface $payment)
    {
        // TODO: Implement notifyPayment() method.
    }

    /**
     * Creates a PayPal payment
     *
     * @param array        $configuration
     * @param Payer        $payer
     * @param RedirectUrls $redirectUrls
     * @param Transaction  $transaction
     *
     * @return Payment
     */
    public function createPayment(array $configuration, Payer $payer, RedirectUrls $redirectUrls, Transaction $transaction) : Payment
    {
        $apiContext = $this->getApiContext($configuration);
        $payment    = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions([$transaction]);

        return $payment->create($apiContext);
    }
    
    /**
     * {@inheritdoc}
     */
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
    
    /**
     * Configures the PayPal API context
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $mode
     *
     * @return ApiContext
     */
    private function getApiContext(string $clientId, string $clientSecret, string $mode) : ApiContext
    {
        PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = 6;
        
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );
        
        $apiContext->setConfig([
            'mode'            => $mode,
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
