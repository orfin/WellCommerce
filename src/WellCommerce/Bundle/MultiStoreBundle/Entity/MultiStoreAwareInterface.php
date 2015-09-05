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

namespace WellCommerce\Bundle\MultiStoreBundle\Entity;

/**
 * Interface MultiStoreAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MultiStoreAwareInterface
{
    /**
     * @param Shop $shop
     */
    public function setShop(Shop $shop);

    /**
     * @return Shop
     */
    public function getShop();
}
