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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\ChangeOrderProductQuantityException;
use WellCommerce\Bundle\OrderBundle\Exception\DeleteOrderProductException;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class OrderProductManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductManager extends Manager implements OrderProductManagerInterface
{
    public function addProductToOrder(ProductInterface $product, VariantInterface $variant = null, int $quantity = 1, OrderInterface $order)
    {
        $orderProduct = $this->findProductInOrder($product, $variant, $order);
        
        if (!$orderProduct instanceof OrderProductInterface) {
            $orderProduct = $this->createOrderProduct($product, $variant, $order);
            $orderProduct->setQuantity($quantity);
            $order->getProducts()->add($orderProduct);
        } else {
            $orderProduct->increaseQuantity($quantity);
        }

        $this->updateResource($order);
    }
    
    public function findProductInOrder(ProductInterface $product, VariantInterface $variant = null, OrderInterface $order)
    {
        return $this->getRepository()->findOneBy([
            'order'   => $order,
            'product' => $product,
            'variant' => $variant
        ]);
    }
    
    public function createOrderProduct(
        ProductInterface $product,
        VariantInterface $variant = null,
        OrderInterface $order
    ) : OrderProductInterface
    {
        /** @var OrderProductInterface $orderProduct */
        $orderProduct = $this->initResource();
        $orderProduct->setOrder($order);
        $orderProduct->setProduct($product);
        $orderProduct->setWeight($product->getWeight());
        $orderProduct->setSellPrice($product->getSellPrice());
        $orderProduct->setBuyPrice($product->getBuyPrice());
        
        if ($variant instanceof VariantInterface) {
            $orderProduct->setVariant($variant);
        }
        
        return $orderProduct;
    }
    
    public function deleteOrderProduct(OrderProductInterface $orderProduct, OrderInterface $order)
    {
        if (false === $order->getProducts()->contains($orderProduct)) {
            throw new DeleteOrderProductException($orderProduct);
        }

        $this->removeResource($orderProduct);
        $this->updateResource($order);
    }
    
    public function changeOrderProductQuantity(OrderProductInterface $orderProduct, OrderInterface $order, int $quantity)
    {
        if (false === $order->getProducts()->contains($orderProduct)) {
            throw new ChangeOrderProductQuantityException($orderProduct);
        }

        if ($quantity < 1) {
            $this->deleteOrderProduct($orderProduct, $order);
        } else {
            $orderProduct->setQuantity($quantity);
        }

        $this->updateResource($order);
    }
}
