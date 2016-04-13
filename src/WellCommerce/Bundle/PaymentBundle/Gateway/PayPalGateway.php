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
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class PayPalGateway
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalGateway extends AbstractContainerAware implements PayPalGatewayInterface
{
    /**
     * @var array
     */
    protected $options;
    
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
    protected function configureOptions(OptionsResolver $resolver)
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
            'log.FileName'    => $this->getKernel()->getLogDir() . '/PayPal.log',
            'log.LogLevel'    => 'DEBUG',
            'cache.enabled'   => true,
            'http.VerifyPeer' => 0,
            'http.VerifyHost' => 2,
        ]);
    }
    
    protected function getPayment(string $identifier, ApiContext $apiContext) : Payment
    {
        return Payment::get($identifier, $apiContext);
    }
    
    /**
     * Configures the PayPal API context
     *
     * @param array $configuration
     *
     * @return ApiContext
     */
    protected function getApiContext(array $configuration) : ApiContext
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
