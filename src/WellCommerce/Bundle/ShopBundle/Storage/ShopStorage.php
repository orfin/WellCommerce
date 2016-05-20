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

namespace WellCommerce\Bundle\ShopBundle\Storage;

use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class ShopStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShopStorage implements ShopStorageInterface
{
    /**
     * @var ShopInterface
     */
    private $currentShop;

    public function getCurrentShopIdentifier() : int
    {
        if ($this->hasCurrentShop()) {
            return $this->getCurrentShop()->getId();
        }

        return 0;
    }

    public function hasCurrentShop() : bool
    {
        return $this->currentShop instanceof ShopInterface;
    }

    public function getCurrentShop() : ShopInterface
    {
        return $this->currentShop;
    }

    public function setCurrentShop(ShopInterface $shop)
    {
        $this->currentShop = $shop;
    }
}
