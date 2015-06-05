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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class CartSummaryProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartSummaryProvider extends AbstractProvider implements CartSummaryProviderInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    protected $converter;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface $converter
     */
    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        $quantity = 0;
        $this->cart->getProducts()->forAll(function ($key, CartProduct $cartProduct) use (&$quantity) {
            $quantity += $cartProduct->getQuantity();
        });

        return $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        $weight = 0;
        $this->cart->getProducts()->forAll(function ($key, CartProduct $cartProduct) use (&$weight) {
            $weight += $cartProduct->getProduct()->getWeight() * $cartProduct->getQuantity();
        });

        return $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        $price = 0;
        $this->cart->getProducts()->forAll(function ($key, CartProduct $cartProduct) use (&$price) {
            $sellPrice     = $cartProduct->getProduct()->getSellPrice();
            $quantityPrice = $sellPrice->getAmount() * $cartProduct->getQuantity();

            $price += $this->converter->convert($quantityPrice, $sellPrice->getCurrency());
        });

        return $price;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotals()
    {
        return [
            'quantity' => $this->getQuantity(),
            'weight'   => $this->getWeight(),
            'price'    => $this->getPrice(),
        ];
    }

}