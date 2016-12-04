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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface MediaInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MediaInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    public function getName(): string;
    
    public function setName(string $name);
    
    public function getPath(): string;
    
    public function setPath(string $path);
    
    public function getMime(): string;
    
    public function setMime(string $mime);
    
    public function getSize(): int;
    
    public function setSize(int $size);
    
    public function getFullName(): string;
    
    public function getExtension(): string;
    
    public function setExtension(string $extension);
}
