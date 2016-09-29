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

use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Class ReviewInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReviewRecommendationInterface extends EntityInterface, EnableableInterface, TimestampableInterface
{
    /**
     * @return bool
     */
    public function getLiked() : bool;
    
    /**
     * @param bool $like
     */
    public function setLiked(bool $like);
    
    /**
     * @return bool
     */
    public function getUnliked() : bool;
    
    /**
     * @param bool $unlike
     */
    public function setUnliked(bool $unlike);
    
    /**
     * @return ReviewInterface
     */
    public function getReview() : ReviewInterface;
    
    /**
     * {@inheritdoc}
     */
    public function setReview(ReviewInterface $review);
    
}
