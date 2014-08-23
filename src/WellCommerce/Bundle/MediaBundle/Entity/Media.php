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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Media
 *
 * @package WellCommerce\Bundle\MediaBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="media")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\MediaBundle\Repository\MediaRepository")
 */
class Media
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $mime;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $size;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto", mappedBy="photo", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $productPhotos;

    public function __construct()
    {
        $this->productPhotos = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns real file name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets file name
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets path
     *
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Returns mime type
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Sets mime type
     *
     * @param $mime
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
    }

    /**
     * Returns extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets extension
     *
     * @param $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Returns file size in bytes
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets file size in bytes
     *
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getFullName()
    {
        return sprintf('%s.%s', $this->id, $this->extension);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getExtension()) {
            $filename   = sha1(uniqid(mt_rand(), true));
            $this->path = sprintf('%s.%s', $filename, $this->getExtension());
        }
    }
}

