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
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class ProductShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShippingMethodProvider extends AbstractShippingMethodProvider implements ProductShippingMethodProviderInterface
{
    /**
     * @var ArrayCollection
     */
    protected $collection;

    /**
     * {@inheritdoc}
     */
    public function getShippingMethodCostsCollection(ProductInterface $cart)
    {
        if (null === $this->collection) {
            $this->collection = $this->getCollection($cart);
        }

        return $this->sortCollection();
    }

    protected function sortCollection()
    {
        $iterator = $this->collection->getIterator();
        $iterator->uasort(function (ShippingMethodCostInterface $a, ShippingMethodCostInterface $b) {
            return ($a->getCost()->getGrossAmount() < $b->getCost()->getGrossAmount()) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

    /**
     * Returns the collection of all shipping method costs for cart
     *
     * @param ProductInterface $product
     *
     * @return ArrayCollection
     */
    protected function getCollection(ProductInterface $product)
    {
        $shippingMethodCostCollection = new ArrayCollection();
        $shippingMethods              = $this->getSupportedShippingMethods();

        $shippingMethods->map(function (ShippingMethodInterface $shippingMethod) use ($product, $shippingMethodCostCollection) {
            $calculator = $this->getCalculator($shippingMethod);
            $costs      = $calculator->calculateProduct($shippingMethod, $product);
            if ($costs instanceof ShippingMethodCostInterface) {
                $shippingMethodCostCollection->add($costs);
            }
        });

        return $shippingMethodCostCollection;
    }
}
