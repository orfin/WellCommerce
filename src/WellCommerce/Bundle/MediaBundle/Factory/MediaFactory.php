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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;

/**
 * Class MediaFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = MediaInterface::class;

    /**
     * @return MediaInterface
     */
    public function create()
    {
        /** @var $media MediaInterface */
        $media = $this->init();
        $media->setSize(0);

        return $media;
    }
}
