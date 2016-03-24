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

namespace WellCommerce\Component\Form\Elements\Optioned;

use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Interface OptionedFieldInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionedFieldInterface extends ElementInterface
{
    /**
     * Adds new option to select
     *
     * @param $value
     * @param $label
     */
    public function addOptionToSelect($value, $label);
}
