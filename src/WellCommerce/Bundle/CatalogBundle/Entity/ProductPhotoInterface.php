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

namespace WellCommerce\Bundle\CatalogBundle\Entity;

use WellCommerce\Bundle\CmsBundle\Entity\MediaInterface;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ProductPhotoInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductPhotoInterface extends TimestampableInterface, ProductAwareInterface, HierarchyAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return MediaInterface
     */
    public function getPhoto();

    /**
     * @param MediaInterface $photo
     */
    public function setPhoto(MediaInterface $photo);

    /**
     * @return bool
     */
    public function getMainPhoto();

    /**
     * @param $mainPhoto
     */
    public function setMainPhoto($mainPhoto);
}
