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
use WellCommerce\Bundle\CartBundle\Entity\CartTotals;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;
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
     * @var CurrencyConverterInterface
     */
    protected $currencyConverter;

    /**
     * Constructor
     *
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param CurrencyConverterInterface     $currencyConverter
     * @param DoctrineHelperInterface        $doctrineHelper
     */
    public function __construct(
        CartProductRepositoryInterface $cartProductRepository,
        CurrencyConverterInterface $currencyConverter,
        DoctrineHelperInterface $doctrineHelper
    ) {
        $this->cartProductRepository = $cartProductRepository;
        $this->doctrineHelper        = $doctrineHelper;
        $this->currencyConverter     = $currencyConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function getCartProductById(Cart $cart, $id)
    {
        return $this->cartProductRepository->findOneBy([
            'cart' => $cart,
            'id'   => $id
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function abandonCart(Cart $cart)
    {
        $em = $this->doctrineHelper->getEntityManager();
        $em->remove($cart);
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProduct(Cart $cart, $id)
    {
        $em          = $this->doctrineHelper->getEntityManager();
        $cartProduct = $this->getCartProductById($cart, $id);

        if (null === $cartProduct) {
            throw new \InvalidArgumentException(sprintf('Cannot delete item "%s" from cart', $id));
        }
        $cart->removeProduct($cartProduct);
        $em->remove($cartProduct);

        $this->recalculateCartTotals($cart);

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
        $cartProduct = $this->cartProductRepository->findProductInCart($cart, $product, $attribute);

        if (null === $cartProduct) {
            $cartProduct = new CartProduct();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setAttribute($attribute);
            $cartProduct->setQuantity($quantity);
            $cart->addProduct($cartProduct);
            $em->persist($cartProduct);
        } else {
            $cartProduct->setQuantity($cartProduct->getQuantity() + (int)$quantity);
        }

        $this->recalculateCartTotals($cart);

        $em->flush();
    }

    /**
     * Recalculates cart totals
     *
     * @param Cart $cart
     */
    public function recalculateCartTotals(Cart $cart)
    {
        $products   = $cart->getProducts();
        $weight     = 0;
        $quantity   = 0;
        $totalNet   = 0;
        $totalGross = 0;

        foreach ($products as $item) {
            $product = $item->getProduct();
            $weight += $product->getWeight() * $item->getQuantity();
            $quantity += $item->getQuantity();
            $totalNet += $this->calculateTotalNet($item, $product);
            $totalGross += $this->calculateTotalGross($item, $product);
        }

        $cartTotals = new CartTotals($quantity, $weight, $totalNet, $totalGross);
        $cart->setTotals($cartTotals);
    }

    /**
     * Calculates net total for cart item
     *
     * @param CartProduct $cartProduct
     * @param Product     $product
     *
     * @return float
     */
    protected function calculateTotalNet(CartProduct $cartProduct, Product $product)
    {
        $quantity      = $cartProduct->getQuantity();
        $sellPriceNet  = $product->getSellPrice()->getAmount();
        $baseCurrency  = $product->getSellPrice()->getCurrency();
        $quantityPrice = $quantity * $sellPriceNet;

        return $this->currencyConverter->convert($quantityPrice, $baseCurrency);
    }

    /**
     * Calculates gross total for cart item
     *
     * @param CartProduct $cartProduct
     * @param Product     $product
     *
     * @return float
     */
    protected function calculateTotalGross(CartProduct $cartProduct, Product $product)
    {
        $quantity       = $cartProduct->getQuantity();
        $sellPriceNet   = $product->getSellPrice()->getAmount();
        $baseCurrency   = $product->getSellPrice()->getCurrency();
        $vat            = 0.23;
        $vatValue       = $sellPriceNet * $vat;
        $sellPriceGross = $sellPriceNet + $vatValue;
        $quantityPrice  = $quantity * $sellPriceGross;

        return $this->currencyConverter->convert($quantityPrice, $baseCurrency);
    }
}
