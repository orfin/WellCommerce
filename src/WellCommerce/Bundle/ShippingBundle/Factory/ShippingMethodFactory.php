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

namespace WellCommerce\Bundle\ShippingBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class ShippingMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodFactory extends EntityFactory
{
    public function create() : ShippingMethodInterface
    {
        /** @var  $shippingMethod ShippingMethodInterface */
        $shippingMethod = $this->init();
        $shippingMethod->setCosts($this->createEmptyCollection());
        $shippingMethod->setEnabled(true);
        $shippingMethod->setHierarchy(0);
        $shippingMethod->setCurrency($this->getDefaultCurrency());
        $shippingMethod->setTax($this->getDefaultTax());
        $shippingMethod->setCalculator($this->getDefaultCalculator()->getAlias());

        return $shippingMethod;
    }

    private function getDefaultCalculator() : ShippingCalculatorInterface
    {
        return $this->get('shipping_method.calculator.collection')->first();
    }
}
