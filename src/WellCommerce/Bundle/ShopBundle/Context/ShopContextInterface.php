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
     * @return \WellCommerce\Bundle\ShopBundle\Entity\ShopInterface
     */
    public function getCurrentShop();

    /**
     * @return null|int
     */
    public function getCurrentShopIdentifier();

    /**
     * @param ShopInterface $shop
     */
    public function setCurrentShop(ShopInterface $shop);

    /**
     * @return bool
     */
    public function hasCurrentShop();

    /**
     * @return string
     */
    public function getSessionAttributeName();
}
