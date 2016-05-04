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
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\OrderBundle\Exception\DeleteCartItemException;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class OrderCartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderCartController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Manager\OrderProductManager
     */
    protected $manager;
    
    public function indexAction() : Response
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('cart.heading.index')
        ]));

        $order    = $this->getOrderStorage()->getCurrentOrder();
        $form = $this->manager->getForm($cart, [
            'validation_groups' => ['order_cart']
        ]);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($cart);
                
                return $this->getRouterHelper()->redirectTo('front.cart.index');
            }
            
            if (count($form->getError())) {
                $this->getFlashHelper()->addError('client.flash.registration.error');
            }
        }
        
        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }
    
    public function addAction(ProductInterface $product, VariantInterface $variant = null, int $quantity = 1) : Response
    {
        $variants = $product->getVariants();
        $order    = $this->getOrderStorage()->getCurrentOrder();
        
        if ($variants->count() && false === $variants->contains($variant)) {
            return $this->redirectToRoute('front.product.view', ['id' => $product->getId()]);
        }
        
        try {
            $this->manager->addProductToOrder($product, $variant, $quantity, $order);
        } catch (AddCartItemException $exception) {
            return $this->jsonResponse([
                'error' => $exception->getMessage(),
            ]);
        }

        $category        = $product->getCategories()->first();
        $recommendations = $this->get('product.helper')->getProductRecommendationsForCategory($category);
        
        $basketModalContent = $this->renderView('WellCommerceOrderBundle:Front/OrderCart:add.html.twig', [
            'product'         => $product,
            'recommendations' => $recommendations
        ]);
        
        $cartPreviewContent = $this->renderView('WellCommerceOrderBundle:Front/OrderCart:preview.html.twig');
        
        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'cartPreviewContent' => $cartPreviewContent,
            'templateData'       => [],
        ]);
    }
    
    public function editAction(CartProductInterface $cartProduct, int $quantity) : Response
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
    
    public function deleteAction(CartProductInterface $cartProduct) : Response
    {
        try {
            $this->manager->deleteCartProduct($cartProduct);
        } catch (DeleteCartItemException $exception) {
            $this->getFlashHelper()->addError($exception->getMessage());
        }
        
        return $this->redirectToAction('index');
    }
    
    private function createCartAddressForm(CartInterface $cart) : FormInterface
    {
        return $this->get('cart_address.form_builder')->createForm([
            'name' => 'cart_address',
        ], $cart);
    }
}
