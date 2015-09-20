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

namespace WellCommerce\Bundle\CartBundle\Calculator\Visitor;

use WellCommerce\Bundle\CartBundle\Calculator\CartTotalsVisitorInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;

/**
 * Class WeightVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WeightVisitor implements CartTotalsVisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $weight = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$weight) {
            $product = $cartProduct->getProduct();

            $weight += $product->getWeight() * $cartProduct->getQuantity();
        });

        $cart->getTotals()->setWeight($weight);
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
