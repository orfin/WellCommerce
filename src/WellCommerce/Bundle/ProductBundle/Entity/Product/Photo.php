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

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class Photo
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Photo implements PhotoInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use HierarchyAwareTrait;
    use ProductAwareTrait;

    /**
     * @var MediaInterface
     */
    protected $photo;

    /**
     * @var bool
     */
    protected $mainPhoto;

    public function getPhoto() : MediaInterface
    {
        return $this->photo;
    }

    public function setPhoto(MediaInterface $photo)
    {
        $this->photo = $photo;
    }

    public function isMainPhoto() : bool
    {
        return $this->mainPhoto;
    }

    public function setMainPhoto(bool $mainPhoto)
    {
        $this->mainPhoto = $mainPhoto;
    }
}
