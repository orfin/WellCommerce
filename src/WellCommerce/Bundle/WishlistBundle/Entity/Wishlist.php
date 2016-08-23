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
namespace WellCommerce\Bundle\WishlistBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class Wishlist
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Wishlist implements WishlistInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use ClientAwareTrait;
    use ProductAwareTrait;
}
