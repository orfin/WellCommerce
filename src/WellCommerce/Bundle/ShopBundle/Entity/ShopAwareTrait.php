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

namespace WellCommerce\Bundle\ShopBundle\Entity;

/**
 * Class ShopAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ShopAwareTrait
{
    /**
     * @var ShopInterface
     */
    protected $shop;
    
    /**
     * @return ShopInterface
     */
    public function getShop() : ShopInterface
    {
        return $this->shop;
    }
    
    /**
     * @param Shop $shop
     */
    public function setShop(ShopInterface $shop)
    {
        $this->shop = $shop;
    }
}
