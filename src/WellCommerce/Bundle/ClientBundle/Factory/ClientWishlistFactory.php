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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientWishlistInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientWishlistFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientWishlistFactory extends AbstractEntityFactory
{
    public function create() : ClientWishlistInterface
    {
        /** @var  $wishlist ClientWishlistInterface */
        $wishlist = $this->init();

        return $wishlist;
    }
}
