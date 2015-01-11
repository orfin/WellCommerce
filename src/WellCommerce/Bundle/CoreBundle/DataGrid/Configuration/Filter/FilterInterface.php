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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filter;

/**
 * Interface FilterInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filter
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FilterInterface
{
    /**
     * Returns column name to which filter was bound
     *
     * @return string
     */
    public function getColumn();

    /**
     * Returns filter values
     *
     * @return array
     */
    public function getValues();
}
