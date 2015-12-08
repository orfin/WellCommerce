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

namespace WellCommerce\Bundle\WishlistBundle\Factory;

use WellCommerce\Bundle\WishlistBundle\Entity\Wishlist;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class WishlistFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WishlistFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\WishlistBundle\Entity\WishlistInterface
     */
    public function create()
    {
        $Wishlist = new Wishlist();

        return $Wishlist;
    }
}
