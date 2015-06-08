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

namespace WellCommerce\Bundle\MultiStoreBundle\Context;

use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Interface ShopContextInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopContextInterface
{
    /**
     * @return \WellCommerce\Bundle\MultiStoreBundle\Entity\Shop
     */
    public function getCurrentScope();

    /**
     * Returns current scopes identifier or null if global scope was set
     *
     * @return null|integer
     */
    public function getCurrentScopeId();

    /**
     * Returns session bag name for context
     *
     * @return string
     */
    public function getSessionBagNamespace();

    /**
     * Sets current context or null
     *
     * @param Shop $shop
     */
    public function setCurrentScope(Shop $shop = null);

    /**
     * Checks whether session contains previous shop data
     *
     * @return bool
     */
    public function hasSessionPreviousData();
}
