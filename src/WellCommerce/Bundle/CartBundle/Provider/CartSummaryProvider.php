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
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorCollection;

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
     * @var float
     */
    protected $totalProductsWeight = 0;

    /**
     * @var float
     */
    protected $totalProductsPrice = 0;

    /**
     * @var float
     */
    protected $totalProductsQuantity = 0;

    /**
     * @var float
     */
    protected $totalCartPrice = 0;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var array
     */
    protected $shippingMethodCalculatorCollection;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface         $converter
     * @param ShippingMethodCalculatorCollection $shippingMethodCalculatorCollection
     */
    public function __construct(
        CurrencyConverterInterface $converter,
        ShippingMethodCalculatorCollection $shippingMethodCalculatorCollection
    ) {
        $this->converter                          = $converter;
        $this->shippingMethodCalculatorCollection = $shippingMethodCalculatorCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * {@inheritdoc}
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }


    /**
     * {@inheritdoc}
     */
    public function getTotalProductsPrice()
    {
        $this->totalProductsPrice = 0;

        $this->cart->getProducts()->forAll(function ($key, CartProduct $cartProduct) {
            $sellPrice     = $cartProduct->getProduct()->getSellPrice();
            $quantityPrice = $sellPrice->getAmount() * $cartProduct->getQuantity();

            $this->totalProductsPrice += $this->converter->convert($quantityPrice, $sellPrice->getCurrency());
        });

        return $this->totalProductsPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getSummary()
    {
        return [
            'price'    => 1,
            'quantity' => 2,
            'weight'   => 3,
            'total'    => 4
        ];
    }

    /**
     * Returns cart total price with shipping cost
     *
     * @return float|int
     */
    public function getTotalCartPrice()
    {
        $shippingCost   = 0;
        $shippingMethod = $this->cart->getShippingMethod();

        if (null !== $shippingMethod) {
            $calculatorAlias = $shippingMethod->getCalculator();
            $shippingCost    = $this->calculateShippingCost($calculatorAlias);
        }

        $this->totalCartPrice = $this->totalProductsPrice + $shippingCost;

        return $this->totalCartPrice;
    }

    /**
     * Calculates shipping cost using provided calculator
     *
     * @param string $alias
     *
     * @return float
     */
    protected function calculateShippingCost($alias)
    {
        $calculator = $this->getShippingCalculator($alias);

        if (null !== $calculator) {
            return $calculator->calculate($this);
        }

        return 0;
    }

    /**
     * Returns the calculator object
     *
     * @param null $alias
     *
     * @return bool|\WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorInterface
     */
    protected function getShippingCalculator($alias)
    {
        if (!$this->shippingMethodCalculatorCollection->has($alias)) {
            return null;
        }

        return $this->shippingMethodCalculatorCollection->get($alias);
    }
}