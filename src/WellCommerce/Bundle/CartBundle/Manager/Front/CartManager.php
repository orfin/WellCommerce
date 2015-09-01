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

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CartBundle\Exception\ChangeCartItemQuantityException;
use WellCommerce\Bundle\CartBundle\Exception\DeleteCartItemException;
use WellCommerce\Bundle\CartBundle\Helper\CartHelperInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
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
    const CART_CHANGED_EVENT = 'cart_changed';

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
     * @var CartProductRepositoryInterface
     */
    protected $cartProductRepository;

    /**
     * Constructor
     *
     * @param CartRepositoryInterface             $cartRepository
     * @param ProductRepositoryInterface          $productRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     * @param CartHelperInterface                 $cartHelper
     * @param CartProductRepositoryInterface      $cartProductRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        CartHelperInterface $cartHelper,
        CartProductRepositoryInterface $cartProductRepository
    ) {
        parent::__construct($cartRepository);
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productRepository          = $productRepository;
        $this->cartHelper                 = $cartHelper;
        $this->cartProductRepository      = $cartProductRepository;
    }

    /**
     * Adds new product to cart
     *
     * @param Product          $product
     * @param ProductAttribute $attribute
     * @param int              $quantity
     *
     * @return bool
     */
    public function addItem(Product $product, ProductAttribute $attribute = null, $quantity)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $currentCart   = $this->getCartProvider()->getCurrentCart();
        $cartProduct   = $this->cartProductRepository->findProductInCart($currentCart, $product, $attribute);

        if (null === $cartProduct) {
            $cartProduct = new CartProduct();
            $cartProduct->setCart($currentCart);
            $cartProduct->setProduct($product);
            $cartProduct->setAttribute($attribute);
            $cartProduct->setQuantity($quantity);
            $currentCart->addProduct($cartProduct);
            $entityManager->persist($cartProduct);
        } else {
            $cartProduct->setQuantity($cartProduct->getQuantity() + (int)$quantity);
        }

        $this->dispatchPostUpdateEvent($currentCart);

        $entityManager->flush();

        return true;
    }

    /**
     * Broadcasts cart update event
     *
     * @param Cart $cart
     */
    private function dispatchPostUpdateEvent(Cart $cart)
    {
        $event = new CartEvent($cart);
        $this->getEventDispatcher()->dispatch(self::CART_CHANGED_EVENT, $event);
    }

    /**
     * Changes item quantity on cart
     *
     * @param int $id
     * @param int $qty
     *
     * @return bool
     */
    public function changeItemQuantity($id, $qty)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $currentCart   = $this->getCartProvider()->getCurrentCart();
        $cartProduct   = $this->getCartProductById($currentCart, $id);

        if (null === $cartProduct) {
            throw new ChangeCartItemQuantityException($id);
        }

        if ($qty < 1) {
            return $this->deleteItem($id);
        }

        $cartProduct->setQuantity($qty);

        $this->dispatchPostUpdateEvent($currentCart);

        $entityManager->flush();

        return true;
    }

    /**
     * Returns the cart product entity
     *
     * @param Cart $cart
     * @param int  $id
     *
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\CartProduct
     */
    public function getCartProductById(Cart $cart, $id)
    {
        return $this->cartProductRepository->findOneBy([
            'cart' => $cart,
            'id'   => $id
        ]);
    }

    /**
     * Deletes the item from cart
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteItem($id)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $currentCart   = $this->getCartProvider()->getCurrentCart();
        $cartProduct   = $this->getCartProductById($currentCart, $id);

        if (null === $cartProduct) {
            throw new DeleteCartItemException($id);
        }

        $currentCart->removeProduct($cartProduct);
        $entityManager->remove($cartProduct);

        $this->dispatchPostUpdateEvent($currentCart);

        $entityManager->flush();

        return true;
    }

    /**
     * Clears the entire cart. New empty cart will be initialized during next kernel request.
     *
     * @param Cart $cart
     */
    public function abandonCart(Cart $cart)
    {
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->remove($cart);
        $em->flush();
    }

    /**
     * Finds enabled product by id
     *
     * @return null|Product
     */
    public function findProduct()
    {
        $id      = (int)$this->getRequestHelper()->getRequestAttribute('id');
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
        $id        = (int)$this->getRequestHelper()->getRequestAttribute('attribute');
        $attribute = $this->productAttributeRepository->findProductAttribute($id, $product);

        return $attribute;
    }
}
