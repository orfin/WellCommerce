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
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class OrderController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function addressAction(Request $request)
    {
        $manager = $this->getManager();
        $cart    = $this->getManager()->getCartProvider()->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $manager->getRedirectHelper()->redirectTo('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.address'),
        ]));

        $form = $this->get('order_address.form_builder')->createForm([
            'name' => 'order_address'
        ], $cart);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->updateResource($cart, $request);

                return $manager->getRedirectHelper()->redirectToAction('confirm');
            }

            if (count($form->getError())) {
                $manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ];
    }

    /**
     * @return \WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManager
     */
    protected function getManager()
    {
        return parent::getManager();
    }

    public function confirmAction(Request $request)
    {
        $manager = $this->getManager();
        $cart    = $manager->getCurrentCart();

        if (null === $cart || $cart->isEmpty()) {
            return $manager->getRedirectHelper()->redirectTo('front.cart.index');
        }

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('order.heading.confirmation'),
        ]));

        $resource = $manager->prepareOrder($cart);
        $form     = $this->get('order_confirmation.form_builder')->createForm([
            'name' => 'order'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->createResource($resource, $request);

                $this->getCartHelper()->abandonCart($cart);

                return $manager->getRedirectHelper()->redirectToAction('index');
            }

            if (count($form->getError())) {
                $manager->getFlashHelper()->addError('order.form.error.confirmation');
            }
        }

        return [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ];
    }
}
