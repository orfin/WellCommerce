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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;

/**
 * Class ProductPhoto
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductPhoto implements ProductPhotoInterface
{
    use Timestampable;
    use HierarchyAwareTrait;
    use ProductAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var MediaInterface
     */
    protected $photo;

    /**
     * @var bool
     */
    protected $mainPhoto;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoto(MediaInterface $photo)
    {
        $this->photo = $photo;
    }

    /**
     * {@inheritdoc}
     */
    public function getMainPhoto()
    {
        return $this->mainPhoto;
    }

    /**
     * {@inheritdoc}
     */
    public function setMainPhoto($mainPhoto)
    {
        $this->mainPhoto = (bool)$mainPhoto;
    }
}
