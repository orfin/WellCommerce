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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;

/**
 * Class BankTransferController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BankTransferController extends AbstractFrontController
{
    /**
     * @var PaymentManagerInterface
     */
    protected $manager;

    public function initializeAction() : Response
    {
        if ($this->manager->getOrderContext()->hasCurrentOrder()) {
            $order     = $this->manager->getOrderContext()->getCurrentOrder();
            $processor = $this->manager->getPaymentProcessor($order->getPaymentMethod()->getProcessor());

            if ('bank_transfer' !== $order->getPaymentMethod()->getProcessor()) {
                return $this->redirectResponse($processor->getInitializeUrl());
            }

            $payment = $this->manager->getFirstPaymentForOrder($order);
            
            return $this->displayTemplate('index', [
                'payment' => $payment
            ]);
        }
        
        return $this->redirectToRoute('front.home_page.index');
    }
}
