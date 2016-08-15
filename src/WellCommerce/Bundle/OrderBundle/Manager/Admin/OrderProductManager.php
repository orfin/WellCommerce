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

namespace WellCommerce\Bundle\OrderBundle\Manager\Admin;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class OrderProductManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductManager extends AbstractAdminManager
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Factory\OrderProductFactory
     */
    protected $factory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function setProductRepository(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Adds or updates a product
     *
     * @param array          $productValues
     * @param OrderInterface $order
     */
    public function addUpdateOrderProduct(array $productValues, OrderInterface $order)
    {
        $orderProduct = $this->repository->findOneBy(['id' => $productValues['id']]);
        if (!$orderProduct instanceof OrderProductInterface) {
            $orderProduct = $this->createOrderProduct($productValues, $order);
            $order->addProduct($orderProduct);
        } else {
            $this->updateOrderProduct($orderProduct, $productValues);
        }
    }

    /**
     * Updates an existing order's product
     *
     * @param OrderProductInterface $orderProduct
     * @param array                 $productValues
     */
    protected function updateOrderProduct(OrderProductInterface $orderProduct, array $productValues)
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

    /**
     * Creates an instance of order product
     *
     * @param array          $productValues
     * @param OrderInterface $order
     *
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface
     */
    protected function createOrderProduct(array $productValues, OrderInterface $order)
    {
        $productId = (int)$productValues['product_id'];
        $product   = $this->productRepository->find($productId);
        if (!$product instanceof ProductInterface) {
            throw new \InvalidArgumentException(sprintf('Cannot add product to order. ID "%s" does not exists.', $productId));
        }

        $orderProduct = $this->initResource();
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setOrder($order);
        $orderProduct->setProduct($product);
        $orderProduct->setVariant(null);
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
