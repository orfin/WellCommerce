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

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Class ReviewInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReviewInterface extends IdentifiableEntityInterface, EnableableInterface, ProductAwareInterface, TimestampableInterface
{
    /**
     * @return string
     */
    public function getNick() : string;

    /**
     * @param string $nick
     */
    public function setNick(string $nick);

    /**
     * @return string
     */
    public function getReview() : string;

    /**
     * @param string $review
     */
    public function setReview(string $review);

    /**
     * @return int
     */
    public function getRating() : int;

    /**
     * @param int $rating
     */
    public function setRating(int $rating);

    /**
     * @return int
     */
    public function getRatingLevel() : int;

    /**
     * @param int $rating
     */
    public function setRatingLevel(int $ratingLevel);

    /**
     * @return int
     */
    public function getRatingRecommendation() : int;

    /**
     * @param int $rating
     */
    public function setRatingRecommendation(int $ratingRecommendation);

}
