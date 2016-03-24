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

namespace WellCommerce\Component\Form\Conditions;

/**
 * Interface ConditionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ConditionInterface
{
    /**
     * Evaluates condition value
     *
     * @param $value
     *
     * @return mixed
     */
    public function evaluate($value);

    /**
     * Returns javascript part for condition
     *
     * @return string
     */
    public function renderJs();
}
