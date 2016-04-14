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

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;

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
        if ($this->manager->getOrderContext()->hasCurrentOrder()) {
            $order     = $this->manager->getOrderContext()->getCurrentOrder();
            $processor = $this->manager->getPaymentProcessor($order->getPaymentMethod()->getProcessor());
            $payment   = $this->manager->getFirstPaymentForOrder($order, $processor);
            
            return $this->displayTemplate('initialize', [
                'payment' => $payment
            ]);
        }
        
        return $this->redirectToRoute('front.home_page.index');
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
}
