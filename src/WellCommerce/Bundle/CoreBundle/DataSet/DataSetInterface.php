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

namespace WellCommerce\Bundle\CoreBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;

/**
 * Interface DataSetInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetInterface
{
    const EVENT_POST_CONFIGURE = 'dataset.post_configure';

    /**
     * Initializes dataset and returns results
     *
     * @param DataSetRequest $request
     *
     * @return mixed
     */
    public function getResults(DataSetRequest $request);

    /**
     * Processes the results
     *
     * @param $rows
     *
     * @return mixed
     */
    public function processResults($rows);

    /**
     * Returns column collection
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection
     */
    public function getColumns();
}
