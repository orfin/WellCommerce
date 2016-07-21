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

namespace WellCommerce\Bundle\ProductBundle\Entity\Product;

use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Interface PhotoInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PhotoInterface extends EntityInterface, TimestampableInterface, ProductAwareInterface, HierarchyAwareInterface
{
    public function getPhoto() : MediaInterface;

    public function setPhoto(MediaInterface $photo);

    public function isMainPhoto() : bool;

    public function setMainPhoto(bool $mainPhoto);
}
