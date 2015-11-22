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

namespace WellCommerce\SalesBundle\Controller\Front;

use WellCommerce\CatalogBundle\Entity\ProductAttributeInterface;
use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\AppBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\AppBundle\Controller\Front\AbstractFrontController;
use WellCommerce\AppBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\SalesBundle\Entity\CartProductInterface;
use WellCommerce\SalesBundle\Exception\AddCartItemException;
use WellCommerce\SalesBundle\Exception\DeleteCartItemException;

/**
 * Class CartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\SalesBundle\Manager\Front\CartManagerInterface
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('cart.heading.index')
        ]));

        $cart = $this->manager->getCartContext()->getCurrentCart();
        $form = $this->manager->getForm($cart, [
            'validation_groups' => ['cart']
        ]);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($cart);

                return $this->getRouterHelper()->redirectTo('front.cart.index');
            }

            if (count($form->getError())) {
                $this->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->displayTemplate('index', [
            'form'         => $form,
            'elements'     => $form->getChildren(),
            'shippingCost' => (null !== $cart->getShippingMethodCost()) ? $cart->getShippingMethodCost()->getCost() : null,
            'summary'      => $this->get('cart_summary.collector')->collect($cart)
        ]);
    }

    /**
     * Adds item to cart or redirects to quick-view
     *
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1)
    {
        if ($product->getAttributes()->count() && !$product->getAttributes()->contains($attribute)) {
            return $this->redirectToRoute('front.product.view', ['id' => $product->getId()]);
        }

        try {
            $this->manager->addProductToCart($product, $attribute, $quantity);
        } catch (AddCartItemException $exception) {
            return $this->jsonResponse([
                'error'         => $exception->getMessage(),
                'previousError' => $exception->getPrevious()->getMessage(),
            ]);
        }

        $category        = $product->getCategories()->first();
        $recommendations = $this->get('product.helper')->getProductRecommendationsForCategory($category);

        $basketModalContent = $this->renderView('WellCommerceSalesBundle:Front/Cart:add.html.twig', [
            'product'         => $product,
            'recommendations' => $recommendations
        ]);

        $cartPreviewContent = $this->renderView('WellCommerceSalesBundle:Front/Common:preview.html.twig');

        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'cartPreviewContent' => $cartPreviewContent
        ]);
    }

    public function editAction(CartProductInterface $cartProduct, $quantity)
    {
        $message = null;

        try {
            $this->manager->changeCartProductQuantity($cartProduct, $quantity);
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return $this->jsonResponse([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function deleteAction(CartProductInterface $cartProduct)
    {
        try {
            $this->manager->deleteCartProduct($cartProduct);
        } catch (DeleteCartItemException $exception) {
            $this->getFlashHelper()->addError($exception->getMessage());
        }

        return $this->redirectToAction('index');
    }
}
