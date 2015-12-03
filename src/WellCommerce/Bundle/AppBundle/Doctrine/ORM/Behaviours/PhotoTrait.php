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

namespace WellCommerce\Bundle\AppBundle\Doctrine\ORM\Behaviours;

use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;

/**
 * Class PhotoTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait PhotoTrait
{
    /**
     * @var MediaInterface
     */
    protected $photo;

    /**
     * @return MediaInterface
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param null|MediaInterface $photo
     */
    public function setPhoto(MediaInterface $photo = null)
    {
        $this->photo = $photo;
    }
}
