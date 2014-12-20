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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours;

use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * Class PhotoTrait
 *
 * @package WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait PhotoTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $photo;

    /**
     * Returns photo
     *
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Sets photo
     *
     * @param Media $photo
     */
    public function setPhoto(Media $photo = null)
    {
        $this->photo = $photo;
    }
} 