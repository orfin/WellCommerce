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

namespace WellCommerce\Bundle\CartBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Helper\CartHelperInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;
use WellCommerce\Bundle\ProductBundle\Repository\ProductAttributeRepositoryInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;

/**
 * Class CartManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CartManager extends AbstractFrontManager
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    protected $productAttributeRepository;

    /**
     * @var CartHelperInterface
     */
    protected $cartHelper;

    /**
     * @param CartHelperInterface $cartHelper
     */
    public function setCartHelper(CartHelperInterface $cartHelper)
    {
        $this->cartHelper = $cartHelper;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function setProductRepository(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ProductAttributeRepositoryInterface $productRepository
     */
    public function setProductAttributeRepository(ProductAttributeRepositoryInterface $productAttributeRepository)
    {
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * Adds new product to cart
     *
     * @param Product          $product
     * @param ProductAttribute $attribute
     * @param int              $quantity
     *
     * @return mixed
     */
    public function addItem(Product $product, ProductAttribute $attribute = null, $quantity)
    {
        $currentCart = $this->getCartProvider()->getCurrentCart();

        return $this->cartHelper->addProductToCart($currentCart, $product, $attribute, (int)$quantity);
    }

    /**
     * Deletes item from cart
     *
     * @return mixed
     */
    public function deleteItem()
    {
        $currentCart = $this->getCartProvider()->getCurrentCart();
        $id          = $this->getRequestHelper()->getAttribute('id');

        return $this->cartHelper->deleteCartProduct($currentCart, $id);
    }

    /**
     * Finds enabled product by id
     *
     * @return null|Product
     */
    public function findProduct()
    {
        $id      = $this->getRequestHelper()->getRequestAttribute('id');
        $product = $this->productRepository->findEnabledProductById($id);

        return $product;
    }

    /**
     * Finds product attribute
     *
     * @param Product $product
     *
     * @return null|\WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute
     */
    public function findProductAttribute(Product $product)
    {
        $id        = $this->getRequestHelper()->getRequestAttribute('attribute');
        $attribute = $this->productAttributeRepository->findProductAttribute($id, $product);

        return $attribute;
    }
}
