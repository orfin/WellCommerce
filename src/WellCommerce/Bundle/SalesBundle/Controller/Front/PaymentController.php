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

namespace WellCommerce\Bundle\SalesBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\SalesBundle\Entity\OrderInterface;

/**
 * Class PaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\SalesBundle\Manager\Front\PaymentManagerInterface
     */
    protected $manager;

    public function indexAction()
    {
        try {
            $order = $this->manager->findOrder();
            $this->manager->registerPayment($order);
        } catch (\Exception $e) {
            return $this->redirectToRoute('front.home_page.index');
        }

        $processor     = $this->getProcessor($order);
        $configuration = $processor->processConfiguration($order->getPaymentMethod()->getConfiguration());

        return $this->displayTemplate($processor->getAlias(), [
            'order'         => $order,
            'configuration' => $configuration
        ]);
    }

    /**
     * @param OrderInterface $order
     *
     * @return \WellCommerce\Bundle\SalesBundle\Processor\PaymentMethodProcessorInterface
     */
    protected function getProcessor(OrderInterface $order)
    {
        $orderProcessor = $order->getPaymentMethod()->getProcessor();
        $processors     = $this->get('payment_method.processor.collection');

        return $processors->get($orderProcessor);
    }
}
