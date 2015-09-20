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

namespace WellCommerce\Bundle\CartBundle\Calculator;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;

/**
 * Class WeightCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WeightCalculator implements CartCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $weight = $this->calculate($cart);
        $cart->getTotals()->setWeight($weight);
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(CartInterface $cart)
    {
        $weight = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$weight) {
            $product = $cartProduct->getProduct();

            $weight += $product->getWeight() * $cartProduct->getQuantity();
        });

        return $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'weight';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
