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
    
    protected $liked   = false;
    protected $unliked = false;
    
    /**
     * @var ReviewInterface
     */
    protected $review;
    
    public function getLiked(): bool
    {
        return $this->liked;
    }
    
    public function setLiked(bool $liked)
    {
        $this->liked = $liked;
    }
    
    public function setUnliked(bool $unliked)
    {
        $this->unliked = $unliked;
    }
    
    public function getUnliked(): bool
    {
        return $this->unliked;
    }
    
    public function getReview(): ReviewInterface
    {
        return $this->review;
    }
    
    public function setReview(ReviewInterface $review)
    {
        $this->review = $review;
    }
}
