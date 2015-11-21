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

namespace WellCommerce\CoreBundle\Component\DataSet\Column;

/**
 * Interface ColumnInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ColumnInterface
{
    /**
     * Returns column alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns column source option
     *
     * @return string
     */
    public function getSource();

    /**
     * Returns true if column uses MySQL aggregate function. False otherwise.
     *
     * @return bool
     */
    public function isAggregated();

    /**
     * Returns a raw SQL select clause
     *
     * @return string
     */
    public function getRawSelect();
}
