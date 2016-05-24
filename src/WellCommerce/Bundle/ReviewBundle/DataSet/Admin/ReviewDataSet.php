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

namespace WellCommerce\Bundle\ReviewBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ReviewDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'                    => 'review.id',
            'nick'                  => 'review.nick',
            'rating'                => 'review.rating',
            'rating_level'          => 'review.ratingLevel',
            'rating_recommendation' => 'review.ratingRecommendation',
            'createdAt'             => 'review.createdAt',
            'product'               => 'product_translation.name',
        ]);

        $configurator->setColumnTransformers([
            'createdAt' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
        ]);
    }
}
