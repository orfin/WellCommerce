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

namespace WellCommerce\Bundle\CartBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\CartShippingMethodProviderInterface;

/**
 * Class CartShippingMethodVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartShippingMethodVisitor implements CartVisitorInterface
{
    /**
     * @var CartShippingMethodProviderInterface
     */
    protected $cartShippingMethodProvider;

    /**
     * Constructor
     *
     * @param CartShippingMethodProviderInterface $cartShippingMethodProvider
     */
    public function __construct(CartShippingMethodProviderInterface $cartShippingMethodProvider)
    {
        $this->cartShippingMethodProvider = $cartShippingMethodProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $cartShippingMethodCost = $cart->getShippingMethodCost();

        if (null === $cartShippingMethodCost) {
            $shippingMethodCostCollection = $this->getShippingMethodCostCollection($cart);
            if ($shippingMethodCostCollection->count()) {
                $cart->setShippingMethodCost($shippingMethodCostCollection->first());
            }
        }
    }

    protected function getShippingMethodCostCollection(CartInterface $cart)
    {
        return $this->cartShippingMethodProvider->getShippingMethodCostsCollection($cart);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'shipping_method';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 10;
    }
}
