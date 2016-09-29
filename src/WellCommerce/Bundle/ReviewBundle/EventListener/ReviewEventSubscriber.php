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

namespace WellCommerce\Bundle\ReviewBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewRecommendation;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewRecommendationInterface;

/**
 * Class ReviewEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReviewEventSubscriber implements EventSubscriber
{
    
    public function getSubscribedEvents()
    {
        return [
            'postPersist',
        ];
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRatioAndLikes($args);
    }
    
    public function updateRatioAndLikes(LifecycleEventArgs $args)
    {
        $reviewRecommendation = $args->getObject();
        
        if ($reviewRecommendation instanceof ReviewRecommendationInterface) {
            $review                         = $reviewRecommendation->getReview();
            $reviewRecommendationRepository = $args->getObjectManager()->getRepository(ReviewRecommendation::class);
            $reviewLikes                    = $reviewRecommendationRepository->findBy([
                'review' => $review,
                'liked'  => true
            ]);
            
            $reviewUnlikes = $reviewRecommendationRepository->findBy([
                'review'  => $review,
                'unliked' => true
            ]);
            
            if (count($reviewUnlikes) > 0) {
                $ratio = count($reviewLikes) / count($reviewUnlikes);
            } else {
                $ratio = 1;
            }
            
            $review->setRatio($ratio);
            $review->setLikes(count($reviewLikes));
        }
    }
}
