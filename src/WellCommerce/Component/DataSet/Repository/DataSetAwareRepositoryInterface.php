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

namespace WellCommerce\Component\DataSet\Repository;

/**
 * Interface DataSetAwareRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetAwareRepositoryInterface
{
    /**
     * Returns repository alias which is used also as dataset identifier
     *
     * @return string
     */
    public function getAlias(): string;
}
