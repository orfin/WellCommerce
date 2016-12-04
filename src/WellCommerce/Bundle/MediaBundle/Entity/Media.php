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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Media
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Media implements MediaInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    
    protected $name      = '';
    protected $path      = '';
    protected $extension = '';
    protected $mime      = '';
    protected $size      = 0;
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getPath(): string
    {
        return $this->path;
    }
    
    public function setPath(string $path)
    {
        $this->path = $path;
    }
    
    public function getMime(): string
    {
        return $this->mime;
    }
    
    public function setMime(string $mime)
    {
        $this->mime = $mime;
    }
    
    public function getSize(): int
    {
        return $this->size;
    }
    
    public function setSize(int $size)
    {
        $this->size = $size;
    }
    
    public function getFullName(): string
    {
        return sprintf('%s.%s', $this->id, $this->extension);
    }
    
    public function getExtension(): string
    {
        return $this->extension;
    }
    
    public function setExtension(string $extension)
    {
        $this->extension = $extension;
    }
    
    public function preUpload()
    {
        if (null !== $this->getExtension()) {
            $filename   = sha1($this->name);
            $this->path = sprintf('%s.%s', $filename, $this->getExtension());
        }
    }
}
