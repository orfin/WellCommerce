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
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class OrderController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function addressAction(Request $request)
    {
        $cart = $this->manager->getCartProvider()->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $this->manager->getRedirectHelper()->redirectTo('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.address'),
        ]));

        $form = $this->get('order_address.form_builder')->createForm([
            'name' => 'order_address'
        ], $cart);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($cart, $request);

                return $this->manager->getRedirectHelper()->redirectToAction('confirm');
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->displayTemplate('address', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }

    public function confirmAction(Request $request)
    {
        $cart = $this->manager->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $this->manager->getRedirectHelper()->redirectTo('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.confirmation'),
        ]));

        $resource = $this->manager->prepareOrder($cart);
        $form     = $this->get('order_confirmation.form_builder')->createForm([
            'name' => 'order'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->createResource($resource, $request);

                $this->getCartHelper()->abandonCart($cart);

                return $this->manager->getRedirectHelper()->redirectToAction('index');
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('order.form.error.confirmation');
            }
        }

        return $this->displayTemplate('confirm', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }
}
