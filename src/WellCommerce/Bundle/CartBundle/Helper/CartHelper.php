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

namespace WellCommerce\Bundle\CartBundle\Helper;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Class CartHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartHelper implements CartHelperInterface
{
    /**
     * @var CartProductRepositoryInterface
     */
    protected $cartProductRepository;

    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * Constructor
     *
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param DoctrineHelperInterface        $doctrineHelper
     */
    public function __construct(
        CartProductRepositoryInterface $cartProductRepository,
        DoctrineHelperInterface $doctrineHelper
    ) {
        $this->cartProductRepository = $cartProductRepository;
        $this->doctrineHelper        = $doctrineHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getCartProduct(Cart $cart, Product $product, ProductAttribute $attribute = null)
    {
        return $this->cartProductRepository->findProductInCart($cart, $product, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function abandonCart(Cart $cart)
    {
        $em = $this->doctrineHelper->getEntityManager();
        $em->clear($cart);
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProduct(Cart $cart, CartProduct $cartProduct)
    {
        $em         = $this->doctrineHelper->getEntityManager();
        $collection = $cart->getProducts();
        $collection->removeElement($cartProduct);
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartProduct $cartProduct, $quantity)
    {
        $em = $this->doctrineHelper->getEntityManager();
        $cartProduct->setQuantity($quantity);
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function addProductToCart(Cart $cart, Product $product, ProductAttribute $attribute = null, $quantity)
    {
        $em          = $this->doctrineHelper->getEntityManager();
        $cartProduct = $this->getCartProduct($cart, $product, $attribute);

        if (null === $cartProduct) {
            $cartProduct = new CartProduct();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setAttribute($attribute);
            $cartProduct->setQuantity($quantity);
            $em->persist($cartProduct);
        } else {
            $cartProduct->setQuantity($cartProduct->getQuantity() + (int)$quantity);
        }

        $em->flush();
    }

    protected function getCartSummary($products)
    {
        $quantity = 0;
        $weight   = 0;
        $price    = 0;

        foreach ($products as $product) {
            $quantity += $product['quantity'];
            $weight += $product['weight'];
            $price += $product['weight'];
        }
    }
}
