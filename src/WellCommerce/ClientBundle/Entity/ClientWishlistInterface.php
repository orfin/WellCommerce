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

namespace WellCommerce\ClientBundle\Entity;

use WellCommerce\CatalogBundle\Entity\ProductAwareInterface;
use WellCommerce\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientWishlistInterface extends ClientAwareInterface, TimestampableInterface, ProductAwareInterface
{
    /**
     * @return int
     */
    public function getId();
}
