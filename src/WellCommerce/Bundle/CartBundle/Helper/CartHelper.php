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
        $products       = $cart->getProducts();
        $quantityTotal  = $this->calculateCartTotalQuantity($products);
        $weightTotal    = $this->calculateCartTotalWeight($products);
        $netTotal       = $this->calculateCartTotalNetPrice($products);
        $grossTotal     = $this->calculateCartTotalGrossPrice($products);
        $taxAmountTotal = $grossTotal - $netTotal;

        $cartTotals = new CartTotals($quantityTotal, $weightTotal, $netTotal, $grossTotal, $taxAmountTotal);
        $cart->setTotals($cartTotals);
    }

    /**
     * Calculates total quantity of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalQuantity($collection)
    {
        $quantity = 0;
        foreach ($collection as $item) {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * Calculates total weight of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalWeight($collection)
    {
        $weight = 0;
        foreach ($collection as $item) {
            $product = $item->getProduct();

            $weight += $product->getWeight() * $item->getQuantity();
        }

        return $weight;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalNetPrice($collection)
    {
        $totalNetPrice = 0;
        foreach ($collection as $item) {
            $product       = $item->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $priceNet      = $product->getSellPrice()->getAmount();
            $quantityPrice = $item->getQuantity() * $priceNet;

            $totalNetPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        }

        return $totalNetPrice;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalGrossPrice($collection)
    {
        $totalGrossPrice = 0;
        foreach ($collection as $item) {
            $product       = $item->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $tax           = $product->getSellPriceTax();
            $priceNet      = $product->getSellPrice()->getAmount();
            $priceGross    = $tax->calculateGrossPrice($priceNet);
            $quantityPrice = $item->getQuantity() * $priceGross;

            $totalGrossPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        }

        return $totalGrossPrice;
    }
}
