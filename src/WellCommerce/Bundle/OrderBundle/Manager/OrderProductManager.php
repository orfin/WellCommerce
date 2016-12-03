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

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\ChangeOrderProductQuantityException;
use WellCommerce\Bundle\OrderBundle\Exception\DeleteOrderProductException;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class OrderProductManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProductManager extends AbstractManager implements OrderProductManagerInterface
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
            'variant' => $variant,
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
    
    public function addUpdateOrderProduct(array $productValues, OrderInterface $order) : OrderProductInterface
    {
        $orderProduct = $this->getRepository()->findOneBy(['id' => $productValues['id']]);
        if (!$orderProduct instanceof OrderProductInterface) {
            $orderProduct = $this->addOrderProduct($productValues, $order);
            $order->addProduct($orderProduct);
        } else {
            $this->updateOrderProduct($orderProduct, $productValues);
        }
        
        return $orderProduct;
    }
    
    private function updateOrderProduct(OrderProductInterface $orderProduct, array $productValues)
    {
        $sellPrice   = $orderProduct->getSellPrice();
        $grossAmount = $productValues['gross_amount'];
        $taxRate     = $orderProduct->getSellPrice()->getTaxRate();
        $netAmount   = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
        
        $sellPrice->setTaxRate($taxRate);
        $sellPrice->setTaxAmount($grossAmount - $netAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setGrossAmount($grossAmount);
        $orderProduct->setWeight($productValues['weight']);
        $orderProduct->setQuantity($productValues['quantity']);
    }
    
    private function addOrderProduct(array $productValues, OrderInterface $order) : OrderProductInterface
    {
        $productId = (int)$productValues['product_id'];
        $product   = $this->getEntityManager()->getRepository(Product::class)->find($productId);
        if (!$product instanceof ProductInterface) {
            throw new \InvalidArgumentException(sprintf('Cannot add product to order. ID "%s" does not exists.', $productId));
        }
        
        /** @var OrderProductInterface $orderProduct */
        $orderProduct = $this->initResource();
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setOrder($order);
        $orderProduct->setProduct($product);
        $orderProduct->setQuantity($productValues['quantity']);
        $orderProduct->setWeight($productValues['weight']);
        
        $sellPrice   = new Price();
        $grossAmount = $productValues['gross_amount'];
        $taxRate     = $product->getSellPriceTax()->getValue();
        $netAmount   = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
        
        $sellPrice->setTaxRate($taxRate);
        $sellPrice->setTaxAmount($grossAmount - $netAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setCurrency($order->getCurrency());
        
        $orderProduct->setSellPrice($sellPrice);
        
        return $orderProduct;
    }
}
