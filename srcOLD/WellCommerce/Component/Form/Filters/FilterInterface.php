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

namespace WellCommerce\Component\Form\Filters;

/**
 * Interface FilterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FilterInterface
{
    /**
     * Filters given value
     *
     * @param $value
     *
     * @return mixed
     */
    public function filterValue($value);

    /**
     * Sets rule options
     *
     * @param array $options
     *
     * @return mixed
     */
    public function setOptions(array $options = []);
}
