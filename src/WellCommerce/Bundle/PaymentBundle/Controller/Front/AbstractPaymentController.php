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
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class AbstractPaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentController extends AbstractFrontController
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

            if ($this->getCurrentPaymentProcessor() !== $processor) {
                return $this->redirectResponse($processor->getInitializeUrl());
            }

            $payment = $this->manager->getFirstPaymentForOrder($order, $processor);

            return $this->displayTemplate('initialize', [
                'payment' => $payment
            ]);
        }

        return $this->redirectToRoute('front.home_page.index');
    }

    abstract protected function getCurrentPaymentProcessor() : PaymentProcessorInterface;
}
