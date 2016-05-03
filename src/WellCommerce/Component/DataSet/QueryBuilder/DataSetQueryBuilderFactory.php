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

namespace WellCommerce\Component\DataSet\QueryBuilder;

use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;

/**
 * Class DataSetQueryBuilderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetQueryBuilderFactory
{
    public function create(DataSetAwareRepositoryInterface $repository) : DataSetQueryBuilderInterface
    {
        return new DataSetQueryBuilder($repository);
    }
}
