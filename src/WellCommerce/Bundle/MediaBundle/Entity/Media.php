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
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Media
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Media extends AbstractEntity implements MediaInterface
{
    use Timestampable;
    use Blameable;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $path;
    
    /**
     * @var string
     */
    protected $extension;
    
    /**
     * @var string
     */
    protected $mime;
    
    /**
     * @var string
     */
    protected $size;
    
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
        return $this->path;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMime() : string
    {
        return $this->mime;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMime(string $mime)
    {
        $this->mime = $mime;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSize() : int
    {
        return $this->size;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFullName() : string
    {
        return sprintf('%s.%s', $this->id, $this->extension);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExtension() : string
    {
        return $this->extension;
    }
    
    /**
     * {@inheritdoc}
     */
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
