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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Loader;

use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataSetLoaderInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetLoaderInterface
{
    /**
     * Returns dataset results
     *
     * @param DataSetInterface        $dataset
     * @param DataSetRequestInterface $request
     *
     * @return array
     */
    public function getResults(DataSetInterface $dataset, DataSetRequestInterface $request);
}
