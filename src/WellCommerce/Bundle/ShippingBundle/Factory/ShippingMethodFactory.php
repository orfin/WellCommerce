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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class ShippingMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodFactory extends AbstractEntityFactory
{
    public function create() : ShippingMethodInterface
    {
        $shippingMethod = new ShippingMethod();
        $shippingMethod->setCosts($this->createEmptyCollection());
        $shippingMethod->setEnabled(true);
        $shippingMethod->setHierarchy(0);
        $shippingMethod->setCurrency(null);
        $shippingMethod->setTax(null);
        $shippingMethod->setCalculator('');
        $shippingMethod->setCountries([]);
        $shippingMethod->setOptionsProvider('');
        
        return $shippingMethod;
    }
}
