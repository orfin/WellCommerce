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

namespace WellCommerce\Core\Form\Rules;

/**
 * Interface RuleInterface
 *
 * @package WellCommerce\Core\Form\Rules
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RuleInterface
{

    /**
     * Checks value against requirements
     *
     * @param $value
     *
     * @return bool
     */
    public function checkValue($value);

    /**
     * renders rules javascript part
     *
     * @return mixed
     */
    public function render();
} 