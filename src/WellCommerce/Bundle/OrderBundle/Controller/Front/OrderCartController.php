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
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\OrderBundle\Manager\OrderProductManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class OrderCartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderCartController extends AbstractFrontController
{
    public function indexAction() : Response
    {
        $order = $this->getOrderProvider()->getCurrentOrder();
        $form  = $this->getForm($order, [
            'validation_groups' => ['order_cart'],
        ]);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($order);
                
                return $this->getRouterHelper()->redirectTo('front.order_cart.index');
            }
            
            if (count($form->getError())) {
                $this->getFlashHelper()->addError('client.flash.registration.error');
            }
        }
        
        return $this->displayTemplate('index', [
            'form'     => $form,
            'order'    => $order,
            'elements' => $form->getChildren(),
        ]);
    }
    
    public function addAction(ProductInterface $product, VariantInterface $variant = null, int $quantity = 1) : Response
    {
        $variants = $product->getVariants();
        $order    = $this->getOrderProvider()->getCurrentOrder();
        
        if ($variants->count() && false === $variants->contains($variant)) {
            return $this->redirectToRoute('front.product.view', ['id' => $product->getId()]);
        }
        
        try {
            $this->getManager()->addProductToOrder(
                $product,
                $variant,
                $quantity,
                $order
            );
        } catch (AddCartItemException $exception) {
            return $this->jsonResponse([
                'error' => $exception->getMessage(),
            ]);
        }
        
        $category        = $product->getCategories()->first();
        $recommendations = $this->get('product.helper')->getProductRecommendationsForCategory($category);
        
        $basketModalContent = $this->renderView('WellCommerceOrderBundle:Front/OrderCart:add.html.twig', [
            'product'         => $product,
            'order'           => $order,
            'recommendations' => $recommendations,
        ]);
        
        $cartPreviewContent = $this->renderView('WellCommerceOrderBundle:Front/OrderCart:preview.html.twig');
        
        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'cartPreviewContent' => $cartPreviewContent,
            'templateData'       => [],
            'productTotal'       => [
                'quantity'    => $order->getProductTotal()->getQuantity(),
                'grossAmount' => $this->getCurrencyHelper()->convertAndFormat($order->getProductTotal()->getGrossPrice()),
            ],
        ]);
    }
    
    public function editAction(Request $request, OrderProductInterface $orderProduct, int $quantity) : Response
    {
        $success = true;
        $message = null;
        $order   = $this->getOrderProvider()->getCurrentOrder();
        
        try {
            $this->getManager()->changeOrderProductQuantity(
                $orderProduct,
                $order,
                $quantity
            );
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        
        if ($request->isXmlHttpRequest()) {
            return $this->jsonResponse([
                'success' => $success,
                'message' => $message,
            ]);
        }
        
        return $this->redirectResponse($request->headers->get('referer'));
    }
    
    public function deleteAction(OrderProductInterface $orderProduct) : Response
    {
        try {
            $this->getManager()->deleteOrderProduct(
                $orderProduct,
                $this->getOrderProvider()->getCurrentOrder()
            );
        } catch (\Exception $e) {
            $this->getFlashHelper()->addError($e->getMessage());
        }
        
        return $this->redirectToAction('index');
    }
    
    protected function getManager() : OrderProductManager
    {
        return parent::getManager();
    }
}
