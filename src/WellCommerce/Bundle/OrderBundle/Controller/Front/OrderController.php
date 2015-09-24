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

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
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
        $cart = $this->manager->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $this->redirectToRoute('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.address'),
        ]));

        $form = $this->buildAddressForm($cart);

        if ($form->isSubmitted()) {
            $this->checkCopyAddress($request->request);
        }

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($cart);

                return $this->redirectToAction('confirm');
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

    /**
     * Copies billing address to shipping address
     *
     * @param ParameterBag $parameters
     */
    protected function checkCopyAddress(ParameterBag $parameters)
    {
        if (1 === (int)$parameters->get('copyAddress')) {
            $billingAddress = $parameters->get('billingAddress');

            $parameters->set('shippingAddress', [
                'shippingAddress.firstName' => $billingAddress['billingAddress.firstName'],
                'shippingAddress.lastName'  => $billingAddress['billingAddress.lastName'],
                'shippingAddress.street'    => $billingAddress['billingAddress.street'],
                'shippingAddress.streetNo'  => $billingAddress['billingAddress.streetNo'],
                'shippingAddress.flatNo'    => $billingAddress['billingAddress.flatNo'],
                'shippingAddress.city'      => $billingAddress['billingAddress.city'],
                'shippingAddress.postCode'  => $billingAddress['billingAddress.postCode'],
                'shippingAddress.country'   => $billingAddress['billingAddress.country']
            ]);
        }
    }

    /**
     * Builds address form
     *
     * @param CartInterface $cart
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    protected function buildAddressForm(CartInterface $cart)
    {
        return $this->get('order_address.form_builder')->createForm([
            'name' => 'order_address'
        ], $cart);
    }

    public function confirmAction()
    {
        $cart = $this->manager->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $this->redirectToRoute('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.confirmation'),
        ]));

        $order = $this->manager->prepareOrder($cart);
        $form  = $this->buildConfirmationForm($order);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->saveOrder($order);

                return $this->redirectToAction('index');
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('order.form.error.confirmation');
            }
        }

        return $this->displayTemplate('confirm', [
            'form'         => $form,
            'elements'     => $form->getChildren(),
            'shippingCost' => (null !== $cart->getShippingMethodCost()) ? $cart->getShippingMethodCost()->getCost() : null,
            'summary'      => $this->get('cart_summary.collector')->collect($cart),
            'order'        => $order,
        ]);
    }

    /**
     * Builds confirmation form
     *
     * @param OrderInterface $order
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    protected function buildConfirmationForm(OrderInterface $order)
    {
        return $form = $this->get('order_confirmation.form_builder')->createForm([
            'name' => 'order'
        ], $order);
    }
}
