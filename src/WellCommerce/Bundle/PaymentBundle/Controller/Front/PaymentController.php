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
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Exception\OrderNotFoundException;

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

    public function indexAction()
    {
        try {
            $order   = $this->manager->findOrder();
            $payment = $this->manager->createPayment($order);
        } catch (OrderNotFoundException $e) {
            return $this->redirectToRoute('front.home_page.index');
        }

        $processor     = $this->getProcessor($order);
        $configuration = $processor->processConfiguration($order->getPaymentMethod()->getConfiguration());

        $processor->executePayment($payment);

        return $this->displayTemplate($processor->getAlias(), [
            'order'         => $order,
            'configuration' => $configuration
        ]);
    }

    /**
     * @param OrderInterface $order
     *
     * @return \WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface
     */
    protected function getProcessor(OrderInterface $order)
    {
        $orderProcessor = $order->getPaymentMethod()->getProcessor();
        $processors     = $this->get('payment_method.processor.collection');

        return $processors->get($orderProcessor);
    }
}
