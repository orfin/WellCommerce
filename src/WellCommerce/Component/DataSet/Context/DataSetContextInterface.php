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

namespace WellCommerce\Component\DataSet\Context;

use Cache\Taggable\TaggablePoolInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataSetContextInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetContextInterface
{
    /**
     * Returns the result of dataset's query
     *
     * @param QueryBuilder            $builder
     * @param DataSetRequestInterface $request
     * @param ColumnCollection        $columns
     * @param CacheOptions            $cache
     *
     * @return array
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache);

    /**
     * Configures the context
     *
     * @param array $options
     */
    public function configure(array $options = []);
}
