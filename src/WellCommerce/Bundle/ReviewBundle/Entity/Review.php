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

namespace WellCommerce\Bundle\ReviewBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class Review
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Review extends AbstractEntity implements ReviewInterface
{
    use Timestampable;
    use ProductAwareTrait;
    use EnableableTrait;

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
    public function getNick() : string
    {
        return $this->nick;
    }

    /**
     * {@inheritdoc}
     */
    public function setNick(string $nick)
    {
        $this->nick = $nick;
    }

    /**
     * {@inheritdoc}
     */
    public function getReview() : string
    {
        return $this->review;
    }

    /**
     * {@inheritdoc}
     */
    public function setReview(string $review)
    {
        $this->review = $review;
    }

    /**
     * {@inheritdoc}
     */
    public function getRating() : int
    {
        return $this->rating;
    }

    /**
     * {@inheritdoc}
     */
    public function setRating(int $rating)
    {
        $this->rating = $rating;
    }
}
