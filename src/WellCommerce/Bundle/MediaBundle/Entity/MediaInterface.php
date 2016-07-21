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

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface MediaInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MediaInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @return string
     */
    public function getPath() : string;
    
    /**
     * @param string $path
     */
    public function setPath(string $path);
    
    /**
     * @return string
     */
    public function getMime() : string;
    
    /**
     * @param string $mime
     */
    public function setMime(string $mime);
    
    /**
     * @return int
     */
    public function getSize() : int;
    
    /**
     * @param int $size
     */
    public function setSize(int $size);
    
    /**
     * @return string
     */
    public function getFullName() : string;
    
    /**
     * @return string
     */
    public function getExtension() : string;
    
    /**
     * @param string $extension
     */
    public function setExtension(string $extension);
}
