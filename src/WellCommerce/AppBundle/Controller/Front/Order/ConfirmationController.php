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

namespace WellCommerce\AppBundle\Controller\Front\Order;

use WellCommerce\AppBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\AppBundle\Controller\Front\AbstractFrontController;
use WellCommerce\AppBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ConfirmationController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConfirmationController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\AppBundle\Manager\Front\OrderConfirmationManager
     */
    protected $manager;

    public function indexAction()
    {
        $cart = $this->manager->getCartContext()->getCurrentCart();

        if ($cart->isEmpty()) {
            return $this->redirectToRoute('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.confirmation'),
        ]));

        $order = $this->manager->prepareOrder($cart);
        $form  = $this->manager->getForm($order);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->saveOrder($order);

                return $this->redirectToRoute('front.payment.index');
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
}
