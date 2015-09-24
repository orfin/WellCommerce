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

/**
 * Interface CartShippingMethodProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartShippingMethodProviderInterface extends ShippingMethodProviderInterface
{
    /**
     * Returns all shipping methods that can handle cart
     *
     * @param CartInterface $cart
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getShippingMethodCostsCollection(CartInterface $cart);
}
