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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class CartShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartShippingMethodProvider extends AbstractShippingMethodProvider implements CartShippingMethodProviderInterface
{
    /**
     * @var ArrayCollection
     */
    protected $collection;

    /**
     * {@inheritdoc}
     */
    public function getShippingMethodCostsCollection(CartInterface $cart)
    {
        if (null === $this->collection) {
            $this->collection = $this->getCollection($cart);
        }

        return $this->collection;
    }

    /**
     * Returns the collection of all shipping method costs for cart
     *
     * @param CartInterface $cart
     *
     * @return ArrayCollection
     */
    protected function getCollection(CartInterface $cart)
    {
        $shippingMethodCostCollection = new ArrayCollection();
        $shippingMethods              = $this->getSupportedShippingMethods();

        $shippingMethods->map(function (ShippingMethodInterface $shippingMethod) use ($cart, $shippingMethodCostCollection) {
            $calculator = $this->getCalculator($shippingMethod);
            $costs      = $calculator->calculateCart($shippingMethod, $cart);
            if ($costs instanceof ShippingMethodCostInterface) {
                $shippingMethodCostCollection->add($costs);
            }
        });

        return $shippingMethodCostCollection;
    }
}
