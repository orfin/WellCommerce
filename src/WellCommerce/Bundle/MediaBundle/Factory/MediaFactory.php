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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\MediaBundle\Entity\MediaInterface;

/**
 * Class MediaFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = MediaInterface::class;
    
    /**
     * @return MediaInterface
     */
    public function create() : MediaInterface
    {
        /** @var $media MediaInterface */
        $media = $this->init();
        $media->setSize(0);
        $media->setName('');
        $media->setMime('');
        $media->setExtension('');
        $media->setPath('');
        
        return $media;
    }
}
