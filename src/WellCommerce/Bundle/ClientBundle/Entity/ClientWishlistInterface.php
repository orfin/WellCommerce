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

namespace WellCommerce\Bundle\ClientBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Interface ClientWishlistInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientWishlistInterface extends IdentifiableEntityInterface, ClientAwareInterface, TimestampableInterface, ProductAwareInterface
{
}
