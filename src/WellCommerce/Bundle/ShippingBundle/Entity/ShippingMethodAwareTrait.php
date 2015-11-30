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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Class ShippingMethodAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ShippingMethodAwareTrait
{
    /**
     * @var ShippingMethodInterface
     */
    protected $shippingMethod;

    /**
     * @return null|ShippingMethodInterface
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param null|ShippingMethodInterface
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod = null)
    {
        $this->shippingMethod = $shippingMethod;
    }
}
