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

namespace WellCommerce\CoreBundle\Component\DataSet\Provider;

/**
 * Interface DataSetProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetProviderInterface
{
    /**
     * Returns current dataset instance
     *
     * @return \WellCommerce\CoreBundle\Component\DataSet\DataSetInterface
     * @throws \WellCommerce\CoreBundle\Exception\MissingDataSetException
     */
    public function getDataSet();

    /**
     * Returns the dataset's results
     *
     * @param string $contextType
     * @param array  $contextOptions
     * @param array  $requestOptions
     *
     * @return array
     */
    public function getResult($contextType, array $contextOptions = [], array $requestOptions = []);
}
