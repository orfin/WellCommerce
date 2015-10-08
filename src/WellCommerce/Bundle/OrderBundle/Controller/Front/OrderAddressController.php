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
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class OrderAddressController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderAddressController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $cart = $this->manager->getCurrentCart();

        if ($cart->isEmpty() || false === $cart->hasMethods()) {
            return $this->redirectToRoute('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.address'),
        ]));

        $form = $this->manager->getForm($cart, [
            'validation_groups' => ['address', 'contact_details']
        ]);

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

        return $this->displayTemplate('index', [
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
}
