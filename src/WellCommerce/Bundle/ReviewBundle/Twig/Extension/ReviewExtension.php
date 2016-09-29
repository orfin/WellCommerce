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
namespace WellCommerce\Bundle\ReviewBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;
use WellCommerce\Bundle\ReviewBundle\Repository\ReviewRecommendationRepositoryInterface;

/**
 * Class ReviewExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReviewExtension extends \Twig_Extension
{
    /**
     * @var ReviewRecommendationRepositoryInterface
     */
    protected $repository;
    
    /**
     * ReviewExtension constructor.
     *
     * @param ReviewRecommendationRepositoryInterface $repository
     */
    public function __construct(ReviewRecommendationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productReviewAverage', [$this, 'getReviewAverage'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getLikesCount', [$this, 'getLikesCount'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getUnlikesCount', [$this, 'getUnlikesCount'], ['is_safe' => ['html']]),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'review';
    }
    
    public function getReviewAverage(Collection $collection) : float
    {
        $totalRating  = 0;
        $reviewsTotal = $collection->count();
        
        $collection->map(function (ReviewInterface $review) use (&$totalRating) {
            $totalRating += $review->getRating();
        });
        
        return ($reviewsTotal > 0) ? round($totalRating / $reviewsTotal, 2) : 0;
    }
    
    public function getLikesCount(int $id)
    {
        $reviewRecommendations = $this->repository->findBy([
            'review' => $id,
            'liked'  => true
        ]);
        
        return count($reviewRecommendations);
    }
    
    public function getUnlikesCount(int $id)
    {
        $reviewRecommendations = $this->repository->findBy([
            'review'  => $id,
            'unliked' => true
        ]);
        
        return count($reviewRecommendations);
    }
}
