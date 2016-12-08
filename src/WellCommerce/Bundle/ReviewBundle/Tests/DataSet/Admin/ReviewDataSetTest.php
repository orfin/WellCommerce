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

namespace WellCommerce\Bundle\ReviewBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ReviewDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('review.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'reviews.id',
            'nick'      => 'reviews.nick',
            'enabled'   => 'reviews.enabled',
            'rating'    => 'reviews.rating',
            'review'    => 'reviews.review',
            'createdAt' => 'reviews.createdAt',
            'product'   => 'product_translation.name',
        ];
    }
}
