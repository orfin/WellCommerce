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

namespace WellCommerce\Core\Type;

/**
 * Interface SuffixTypeInterface
 *
 * @package WellCommerce\Core\Type
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SuffixTypeInterface
{

    /**
     * Returns suffix alias
     *
     * @return mixed
     */
    public function getAlias();

    /**
     * Calculates new value using modifier
     *
     * @param $value
     * @param $modifier
     *
     * @return mixed
     */
    public function calculate($value, $modifier);
} 