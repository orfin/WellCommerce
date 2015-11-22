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
namespace WellCommerce\AppBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use WellCommerce\AppBundle\Entity\ProductReviewInterface;

/**
 * Class ProductReviewExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductReviewExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productReviewAverage', [$this, 'getProductReviewAverage'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_review';
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
    public function getProductReviewAverage(Collection $collection)
    {
        $totalRating  = 0;
        $reviewsTotal = $collection->count();

        $collection->map(function (ProductReviewInterface $review) use (&$totalRating) {
            $totalRating += $review->getRating();
        });

        return ($reviewsTotal > 0) ? round($totalRating / $reviewsTotal, 2) : 0;
    }
}
