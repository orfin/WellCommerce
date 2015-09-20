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
 * Class QuantityVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class QuantityVisitor implements CartTotalsVisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $quantity = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$quantity) {
            $quantity += $cartProduct->getQuantity();
        });

        $cart->getTotals()->setQuantity($quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'quantity';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
