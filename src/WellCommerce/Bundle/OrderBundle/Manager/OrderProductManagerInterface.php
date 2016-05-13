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

use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Interface OrderProductManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductManagerInterface extends ManagerInterface
{
    public function addProductToOrder(
        ProductInterface $product,
        VariantInterface $variant = null,
        int $quantity = 1,
        OrderInterface $order
    );

    public function findProductInOrder(ProductInterface $product, VariantInterface $variant = null, OrderInterface $order);

    public function createOrderProduct(
        ProductInterface $product,
        VariantInterface $variant = null,
        OrderInterface $order
    ) : OrderProductInterface;

    public function deleteOrderProduct(OrderProductInterface $orderProduct, OrderInterface $order);

    public function changeOrderProductQuantity(OrderProductInterface $orderProduct, OrderInterface $order, int $quantity);
}
