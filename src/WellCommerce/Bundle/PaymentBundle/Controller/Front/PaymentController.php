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

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Manager\PaymentManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

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
    
    public function initializeAction(string $token)
    {
        $payment       = $this->getManager()->findPaymentByToken($token);
        $order         = $payment->getOrder();
        $processor     = $this->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
        $processorName = ucfirst(Inflector::camelize($processor->getConfigurator()->getName()));

        $content = $this->renderView(sprintf('WellCommercePaymentBundle:Front/%s:initialize.html.twig', $processorName), [
            'payment' => $payment
        ]);

        return new Response($content);
    }

    public function confirmAction(string $token)
    {

    }
    
    public function cancelAction(string $token)
    {
        
    }
    
    public function executeAction(string $token)
    {
        
    }

    public function notifyAction(string $token)
    {
        
    }

    protected function getManager() : PaymentManagerInterface
    {
        return parent::getManager();
    }

    private function getPaymentProcessor(string $name) : PaymentProcessorInterface
    {
        return $this->get('payment.processor.collection')->get($name);
    }
}
