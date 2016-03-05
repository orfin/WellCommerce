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

namespace WellCommerce\Component\DataSet\Request;

/**
 * Class DataSetRequestFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetRequestFactory
{
    /**
     * Creates a request object
     *
     * @param array $options
     *
     * @return DataSetRequest
     */
    public function create(array $options = [])
    {
        return new DataSetRequest($options);
    }
}
