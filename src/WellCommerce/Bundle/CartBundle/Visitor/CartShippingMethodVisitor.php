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

use Doctrine\Common\Util\Debug;
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
        if (null === $cart->getShippingMethod()) {
            $defaultMethod = $this->getDefaultShippingMethod($cart);
            if (null !== $defaultMethod) {
                $cart->setShippingMethod($defaultMethod);
            }
        }
    }

    /**
     * Resolves default shipping method for cart after initialization
     *
     * @param CartInterface $cart
     *
     * @return null|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface
     */
    protected function getDefaultShippingMethod(CartInterface $cart)
    {
        $shippingMethodCostCollection = $this->cartShippingMethodProvider->getShippingMethodCostsCollection($cart);
        if ($shippingMethodCostCollection->count()) {
            $defaultShippingMethodCost = $shippingMethodCostCollection->first();

            return $defaultShippingMethodCost->getShippingMethod();
        }

        return null;
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
