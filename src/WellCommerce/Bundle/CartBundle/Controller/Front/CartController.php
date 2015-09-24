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

namespace WellCommerce\Bundle\CartBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\CartBundle\Exception\DeleteCartItemException;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class CartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('cart.heading.index')
        ]));

        $cart = $this->manager->getCurrentCart();
        $form = $this->manager->getForm($cart);

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
     * Add cart item action
     *
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(ProductInterface $product, ProductAttributeInterface $attribute = null)
    {
        $quantity = (int)$this->getRequestHelper()->getRequestAttribute('qty', 1);

        try {
            $this->manager->addProductToCart($product, $attribute, $quantity);
        } catch (AddCartItemException $exception) {
            return $this->jsonResponse([
                'error' => $exception->getMessage()
            ]);
        }

        $category        = $product->getCategories()->first();
        $recommendations = $this->getRecommendations($category);

        $basketModalContent = $this->renderView('WellCommerceCartBundle:Front/Cart:add.html.twig', [
            'product'         => $product,
            'recommendations' => $recommendations
        ]);

        $cartPreviewContent = $this->renderView('WellCommerceCartBundle:Front/Common:preview.html.twig');

        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'cartPreviewContent' => $cartPreviewContent
        ]);
    }

    protected function getRecommendations(Category $category)
    {
        $provider          = $this->manager->getProductProvider();
        $collectionBuilder = $provider->getCollectionBuilder();
        $conditions        = new ConditionsCollection();
        $conditions->add(new Eq('category', $category->getId()));

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => 3,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $conditions
        ]);

        return $dataset;
    }

    public function editAction(CartProductInterface $cartProduct)
    {
        $message  = null;
        $quantity = (int)$this->getRequestHelper()->getRequestAttribute('qty', 1);

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
        $message = null;

        try {
            $this->manager->deleteCartProduct($cartProduct);
            $success = true;
        } catch (DeleteCartItemException $exception) {
            $success = false;
            $message = $exception->getMessage();
        }

        return $this->jsonResponse([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
