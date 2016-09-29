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
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Review
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewRecommendation implements ReviewRecommendationInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use EnableableTrait;
    
    /**
     * @var int
     */
    protected $liked;
    
    /**
     * @var int
     */
    protected $unliked;
    
    /**
     * @var ReviewInterface
     */
    protected $review;
    
    /**
     * {@inheritdoc}
     */
    public function getLiked() : bool
    {
        return $this->liked;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLiked(bool $liked)
    {
        $this->liked = $liked;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUnliked(bool $unliked)
    {
        $this->unliked = $unliked;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnliked() : bool
    {
        return $this->unliked;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReview() : ReviewInterface
    {
        return $this->review;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReview(ReviewInterface $review)
    {
        $this->review = $review;
    }
}
