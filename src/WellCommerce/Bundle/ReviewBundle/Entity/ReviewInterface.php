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
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Class ReviewInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReviewInterface extends EntityInterface, EnableableInterface, ProductAwareInterface, TimestampableInterface
{
    public function getNick(): string;
    
    public function setNick(string $nick);
    
    public function getReview(): string;
    
    public function setReview(string $review);
    
    public function getRating(): int;
    
    public function setRating(int $rating);
    
    public function getRatingLevel(): int;
    
    public function setRatingLevel(int $ratingLevel);
    
    public function getRatingRecommendation(): int;
    
    public function setRatingRecommendation(int $ratingRecommendation);
    
    public function getReviewRecommendations(): Collection;
    
    public function setReviewRecommendations(Collection $reviewRecommendations);
}
