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

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class ClientWishlist
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlist extends AbstractEntity implements ClientWishlistInterface
{
    use Timestampable;
    use ClientAwareTrait;
    use ProductAwareTrait;
}
