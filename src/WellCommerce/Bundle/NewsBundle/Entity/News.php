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
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\FormBundle\Form\Elements\DateTime;

/**
 * Class Locale
 *
 * @package WellCommerce\Bundle\NewsBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\NewsBundle\Repository\NewsRepository")
 */
class News
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @ORM\Column(name="publish", type="boolean", options={"default" = 0})
     *
     */

    private $publish;

    /**
     * @var datetime $startDate
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     */

    private $startDate;

    /**
     * @var datetime $endDate
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     */

    private $endDate;

    /**
     * @ORM\Column(name="featured", type="boolean")
     *
     */

    private $featured;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\NewsBundle\Entity\NewsPhoto", mappedBy="news", cascade={"persist"}, orphanRemoval=true)
     */

    private $newsPhotos;


    /**
     * Get id.
     *
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;
    }


    public function getPublish()
    {
        return $this->publish;
    }

    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate(DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    public function getFeatured()
    {
        return $this->featured;
    }

    public function getNewsPhotos()
    {
        return $this->newsPhotos;
    }

    /**
     *
     * @param NewsPhoto $photo
     */
    public function addNewsPhoto(NewsPhoto $photo)
    {
        $this->newsPhotos[] = $photo;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function setNewsPhotos(array $data)
    {
        $params     = $data['data'];
        $collection = $data['collection'];
        $newsPhotos = new ArrayCollection();

        // if collection was not modified, do nothing
        if ($params['unmodified'] == 1) {
            return false;
        }

        foreach ($collection as $photo) {
            $mainPhoto = (int)($photo->getId() == $params['main']);
            $newsPhoto = new NewsPhoto();
            $newsPhoto->setPhoto($photo);
            $newsPhoto->setMainPhoto($mainPhoto);
            $newsPhoto->setProduct($this);
            $newsPhotos->add($newsPhoto);

            // ad main photo as product default photo
            if ($mainPhoto == 1) {
                $this->setPhoto($photo);
            }
        }

        // loop through old photos and remove those which haven't been submitted
        foreach ($this->newsPhotos as $oldPhoto) {
            if (!$newsPhotos->contains($oldPhoto)) {
                $this->newsPhotos->removeElement($oldPhoto);
            }
        }

        // if we don't have any photos, reset main product photo
        if ($newsPhotos->count() == 0) {
            $this->setPhoto(null);
        }
        $this->newsPhotos = $newsPhotos;
    }
}

