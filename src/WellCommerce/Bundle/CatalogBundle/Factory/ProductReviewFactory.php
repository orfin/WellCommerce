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

namespace WellCommerce\Bundle\CatalogBundle\Factory;

use WellCommerce\Bundle\CatalogBundle\Entity\ProductReview;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class ProductReviewFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductReviewFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\CatalogBundle\Entity\ProductReviewInterface
     */
    public function create()
    {
        $productReview = new ProductReview();

        return $productReview;
    }
}
