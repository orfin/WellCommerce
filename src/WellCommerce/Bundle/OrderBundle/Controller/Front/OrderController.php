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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManager;
use WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManagerInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;

/**
 * Class OrderController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderController extends AbstractFrontController
{
    /**
     * @var OrderManager
     */
    protected $manager;
    
    public function confirmAction(Request $request) : Response
    {
        $cart = $this->manager->getCartContext()->getCurrentCart();
        if (false === $this->getValidatorHelper()->isValid($cart, ['order'])) {
            return $this->redirectToRoute('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.confirmation'),
        ]));

        $order = $this->manager->initResource();
        $form  = $this->manager->getForm($order);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getOrderManager()->createResource($order);
                $payment = $this->getPaymentManager()->createFirstPaymentForOrder($order);

                return $this->redirectToRoute('front.payment.initialize', ['token' => $payment->getToken()]);
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('order.form.error.confirmation');
            }
        }

        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
            'summary'  => $this->get('cart_summary.collector')->collect($cart),
            'order'    => $order
        ]);
        
    }
    
    private function getOrderManager() : ManagerInterface
    {
        return $this->get('order.manager');
    }

    private function getPaymentManager() : ManagerInterface
    {
        return $this->get('payment.manager');
    }
}
