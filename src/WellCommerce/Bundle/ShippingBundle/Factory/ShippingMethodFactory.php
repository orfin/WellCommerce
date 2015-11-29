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

namespace WellCommerce\Bundle\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\AppBundle\Entity\ShippingMethod;

/**
 * Class ShippingMethodFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\AppBundle\Entity\ShippingMethodInterface
     */
    public function create()
    {
        $shippingMethod = new ShippingMethod();
        $shippingMethod->setCosts(new ArrayCollection());
        $shippingMethod->setEnabled(true);
        $shippingMethod->setHierarchy(0);

        return $shippingMethod;
    }
}
