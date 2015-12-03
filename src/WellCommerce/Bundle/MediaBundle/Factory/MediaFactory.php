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

namespace WellCommerce\Bundle\MediaBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\MediaBundle\Entity\Media;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class MediaFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $media = new Media();

        return $media;
    }
}
