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

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class Review
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Review implements ReviewInterface
{
    use IdentifiableTrait;
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
     * @var int
     */
    protected $ratingLevel;
    
    /**
     * @var int
     */
    protected $ratingRecommendation;
    
    /**
     * @var float
     */
    protected $ratio;
    
    /**
     * @var int
     */
    protected $likes;
    
    /**
     * @var Collection
     */
    protected $reviewRecommendations;
    
    /**
     * {@inheritdoc}
     */
    public function getNick () : string
    {
        return $this->nick;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNick (string $nick)
    {
        $this->nick = $nick;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReview () : string
    {
        return $this->review;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReview (string $review)
    {
        $this->review = $review;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRating () : int
    {
        return $this->rating;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRating (int $rating)
    {
        $this->rating = $rating;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRatingLevel () : int
    {
        return $this->ratingLevel;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRatingLevel (int $ratingLevel)
    {
        $this->ratingLevel = $ratingLevel;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getRatio () : float
    {
        return $this->ratio;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRatio (float $ratio)
    {
        $this->ratio = $ratio;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLikes () : int
    {
        return $this->likes;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLikes (int $likes)
    {
        $this->likes = $likes;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRatingRecommendation () : int
    {
        return $this->ratingRecommendation;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRatingRecommendation (int $ratingRecommendation)
    {
        $this->ratingRecommendation = $ratingRecommendation;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getReviewRecommendations () : Collection
    {
        return $this->reviewRecommendations;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReviewRecommendations (Collection $reviewRecommendations)
    {
        $this->reviewRecommendations = $reviewRecommendations;
    }
    
    public function addRecommendation (ReviewRecommendationInterface $reviewRecommendation)
    {
        $this->reviewRecommendations[] = $reviewRecommendation;
    }
}
