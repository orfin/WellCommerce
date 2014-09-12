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

namespace WellCommerce\Bundle\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\MetaDataTrait;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * NewsPhoto
 *
 * @ORM\Table(name="news_photo")
 * @ORM\Entity
 */
class NewsPhoto
{
    use Timestampable;
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MediaBundle\Entity\Media", inversedBy="newsPhotos")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id", nullable=false)
     */
    protected $photo;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\NewsBundle\Entity\News", inversedBy="newsPhotos")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=false)
     */
    protected $news;

    /**
     * @ORM\Column(name="main_photo", type="boolean", options={"default":0})
     */
    private $mainPhoto;

    public function setNews(News $news)
    {
        $this->news = $news;
    }

    public function setPhoto(Media $photo)
    {
        $this->photo = $photo;
    }

    public function getPhoto()
    {
        return $this->photo;
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

