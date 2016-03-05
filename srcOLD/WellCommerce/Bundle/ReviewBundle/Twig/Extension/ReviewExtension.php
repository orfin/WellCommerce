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

/**
 * Class ReviewExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productReviewAverage', [$this, 'getReviewAverage'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'review';
    }

    /**
     * Returns product statuses
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getReviewAverage(Collection $collection)
    {
        $totalRating  = 0;
        $reviewsTotal = $collection->count();

        $collection->map(function (ReviewInterface $review) use (&$totalRating) {
            $totalRating += $review->getRating();
        });

        return ($reviewsTotal > 0) ? round($totalRating / $reviewsTotal, 2) : 0;
    }
}
