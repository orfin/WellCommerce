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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\Column;

/**
 * Interface ColumnInterface
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Column
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
     * Returns true if column uses aggregation
     *
     * @return string
     */
    public function isAggregated();

    /**
     * Returns select clause with column alias
     *
     * @return mixed
     */
    public function getRawSelect();

    /**
     * Returns column transformer
     *
     * @return \WellCommerce\Bundle\DataSetBundle\DataSet\Transformer\TransformerInterface
     */
    public function getTransformer();

    /**
     * Checks whether column has transformer
     *
     * @return bool
     */
    public function hasTransformer();
}