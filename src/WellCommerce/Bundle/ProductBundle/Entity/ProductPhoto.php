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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * ProductPhoto
 *
 * @ORM\Table(name="product_photo")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ProductBundle\Repository\ProductPhotoRepository")
 */
class ProductPhoto
{
    use Timestampable;
    use HierarchyTrait;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MediaBundle\Entity\Media", inversedBy="productPhotos")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id", nullable=false)
     */
    protected $photo;
    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", inversedBy="productPhotos")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="main_photo", type="boolean", options={"default":0})
     */
    private $mainPhoto;

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto(Media $photo)
    {
        $this->photo = $photo;
    }

    public function getMainPhoto()
    {
        return $this->mainPhoto;
    }

    public function setMainPhoto($mainPhoto)
    {
        $this->mainPhoto = $mainPhoto;

    }
}

