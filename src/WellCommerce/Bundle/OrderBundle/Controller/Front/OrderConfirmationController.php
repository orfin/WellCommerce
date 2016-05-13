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

namespace WellCommerce\Bundle\OrderBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;

/**
 * Class OrderConfirmationController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderConfirmationController extends AbstractFrontController
{
    public function indexAction() : Response
    {
        $order = $this->getOrderProvider()->getCurrentOrder();
        $order->setConfirmed(true);

        if ($order->isEmpty()) {
            return $this->redirectToRoute('front.order_cart.index');
        }

        $form = $this->getForm($order);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($order);
                $payment = $this->getPaymentForOrder($order);
                
                return $this->redirectToRoute('front.payment.initialize', ['token' => $payment->getToken()]);
            }
            
            if (count($form->getError())) {
                $this->getFlashHelper()->addError('order.form.error.confirmation');
            }
        }
        
        return $this->displayTemplate('index', [
            'form'     => $form,
            'order'    => $order,
            'elements' => $form->getChildren(),
        ]);
    }

    private function getPaymentForOrder(OrderInterface $order) : PaymentInterface
    {
        return $order->getPayments()->first();
    }
}
