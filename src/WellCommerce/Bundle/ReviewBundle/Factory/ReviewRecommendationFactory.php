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

namespace WellCommerce\Bundle\ReviewBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewRecommendation;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewRecommendationInterface;

/**
 * Class ReviewRecommendationFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReviewRecommendationFactory extends AbstractEntityFactory
{
    public function create() : ReviewRecommendationInterface
    {
        $recommendation = new ReviewRecommendation();
        $recommendation->setLiked(false);
        $recommendation->setUnliked(false);
        
        return $recommendation;
    }
}
