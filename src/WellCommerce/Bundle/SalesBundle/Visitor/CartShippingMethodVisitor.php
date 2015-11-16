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

namespace WellCommerce\Bundle\SalesBundle\Visitor;

use WellCommerce\Bundle\SalesBundle\Entity\CartInterface;
use WellCommerce\Bundle\SalesBundle\Provider\CartShippingMethodProviderInterface;
use WellCommerce\Bundle\SalesBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class CartShippingMethodVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartShippingMethodVisitor implements CartVisitorInterface
{
    /**
     * @var ShippingMethodProviderInterface
     */
    protected $shippingMethodProvider;

    /**
     * Constructor
     *
     * @param ShippingMethodProviderInterface $shippingMethodProvider
     */
    public function __construct(ShippingMethodProviderInterface $shippingMethodProvider)
    {
        $this->shippingMethodProvider = $shippingMethodProvider;
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
        return $this->shippingMethodProvider->getShippingMethodCostsCollection($cart);
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
