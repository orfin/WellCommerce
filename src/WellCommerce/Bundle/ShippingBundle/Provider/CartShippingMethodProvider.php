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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Options\ShippingOptionsCollection;

/**
 * Class CartShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartShippingMethodProvider extends AbstractShippingMethodProvider implements CartShippingMethodProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShippingMethodOptions(CartInterface $cart)
    {
        $shippingOptionsCollection = new ShippingOptionsCollection();
        $shippingMethods           = $this->getSupportedShippingMethods($cart);

        $shippingMethods->map(function (ShippingMethodInterface $shippingMethod) use ($cart, $shippingOptionsCollection) {
            $calculator = $this->getCalculator($shippingMethod);
            $costs      = $calculator->calculateCart($shippingMethod, $cart);
            $option     = $this->createShippingOption($shippingMethod, $costs);
            $shippingOptionsCollection->add($option);
        });

        return $shippingOptionsCollection;
    }

    /**
     * Returns all enabled shipping methods which are supporting cart calculations
     *
     * @param CartInterface $cart
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    protected function getSupportedShippingMethods(CartInterface $cart)
    {
        $methods = $this->getEnabledMethods();

        return $methods->filter(function (ShippingMethodInterface $shippingMethod) use ($cart) {
            $calculator = $this->getCalculator($shippingMethod);

            return $calculator->supportsCart($shippingMethod, $cart);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function supports($class)
    {
        return ($class instanceof CartInterface);
    }
}
