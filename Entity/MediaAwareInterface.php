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

namespace WellCommerce\Bundle\MediaBundle\Entity;

/**
 * Interface MediaAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MediaAwareInterface
{
    /**
     * @return MediaInterface
     */
    public function getMedia();

    /**
     * @param null|MediaInterface $media
     */
    public function setMedia(MediaInterface $media = null);
}
