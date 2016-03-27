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

namespace WellCommerce\Bundle\ShopBundle\Context;

use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Interface ShopContextInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopContextInterface
{
    /**
     * @return ShopInterface
     */
    public function getCurrentShop() : ShopInterface;

    /**
     * @return int
     */
    public function getCurrentShopIdentifier() : int;

    /**
     * @param ShopInterface $shop
     */
    public function setCurrentShop(ShopInterface $shop);

    /**
     * @return bool
     */
    public function hasCurrentShop() : bool;

    /**
     * @return string
     */
    public function getSessionAttributeName() : string;
}
