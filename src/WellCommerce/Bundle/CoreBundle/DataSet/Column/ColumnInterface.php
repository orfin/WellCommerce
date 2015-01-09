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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

/**
 * Interface ColumnInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet\Column
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
}