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

namespace WellCommerce\Bundle\ProductBundle\Collection\Column;

/**
 * Interface ColumnInterface
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ColumnInterface
{
    /**
     * Returns column identifier
     *
     * @return string
     */
    public function getId();

    /**
     * Returns column source option
     *
     * @return string
     */
    public function getSource();

    /**
     * Returns prepared select column string
     *
     * @return string
     */
    public function getRawSelect();

    /**
     * Returns columns processing function
     *
     * @return array
     */
    public function getProcessFunction();
}