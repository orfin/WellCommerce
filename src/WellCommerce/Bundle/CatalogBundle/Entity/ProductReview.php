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

namespace WellCommerce\Bundle\CatalogBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;
use WellCommerce\Bundle\CoreBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;

/**
 * Class ProductReview
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductReview implements ProductReviewInterface
{
    use Timestampable;
    use ProductAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $nick;

    /**
     * @var string
     */
    protected $review;

    /**
     * @var int
     */
    protected $rating;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * {@inheritdoc}
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * {@inheritdoc}
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * {@inheritdoc}
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * {@inheritdoc}
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * {@inheritdoc}
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
}
