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

use WellCommerce\Bundle\AppBundle\Entity\ClientWishlist;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class ClientWishlistFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\AppBundle\Entity\ClientWishlistInterface
     */
    public function create()
    {
        $clientWishlist = new ClientWishlist();

        return $clientWishlist;
    }
}
