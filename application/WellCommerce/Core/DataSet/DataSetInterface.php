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

namespace WellCommerce\Core\DataSet;

/**
 * Interface DataSetInterface
 *
 * @package WellCommerce\Core\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetInterface
{
    const DATASET_INIT_EVENT = 'dataset.init';

    public function addColumns();

    public function getRows();

    public function getTotal();

    public function getCacheKey();

    public function isCacheEnabled();

    public function getTtl();
}