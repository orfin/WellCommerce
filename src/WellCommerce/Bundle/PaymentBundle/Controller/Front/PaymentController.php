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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface;

/**
 * Class PaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface
     */
    protected $manager;
    
    public function indexAction() : Response
    {
        try {
            $order = $this->manager->findOrder();
            
        } catch (\Exception $e) {
            return $this->redirectToRoute('front.home_page.index');
        }
        
        $processor = $this->getProcessor($order->getPaymentMethod()->getProcessor());
        $payment   = $this->manager->createPayment($order, $processor);

        return $this->displayTemplate($processor->getAlias(), [
            'payment' => $processor->processPayment($payment),
        ]);
    }
    
    public function confirmAction($processor, Request $request) : Response
    {
        $processor = $this->getProcessor($processor);
        $payment   = $processor->confirmPayment($request);
        
        return $this->displayTemplate($processor->getAlias(), [
            'payment' => $payment,
        ]);
    }
    
    public function cancelAction(Request $request) : Response
    {
        try {
            $order = $this->manager->findOrder();

        } catch (\Exception $e) {
            return $this->redirectToRoute('front.home_page.index');
        }

        $processor = $this->getProcessor($order->getPaymentMethod()->getProcessor());

        return $this->displayTemplate($processor->getAlias(), [
            'payment' => $processor->cancelPayment($order, $request)
        ]);
    }
    
    public function notifyAction(Request $request) : Response
    {
        
    }
    
    protected function getProcessor(string $alias) : PaymentMethodProcessorInterface
    {
        $processors = $this->get('payment_method.processor.collection');
        
        return $processors->get($alias);
    }
}
