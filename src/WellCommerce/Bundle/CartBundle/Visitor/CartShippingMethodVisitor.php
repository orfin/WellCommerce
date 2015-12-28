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
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;

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

    protected function getShippingMethodCostCollection(CartInterface $cart)
    {
        return $this->shippingMethodProvider->getShippingMethodCostsCollection($cart);
    }
}
