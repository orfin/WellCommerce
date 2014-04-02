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

namespace WellCommerce\Core\Component\Form;

/**
 * Class filter
 *
 * @package WellCommerce\Core\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class Filter
{
    public function filter($values)
    {
        if (is_array($values)) {
            foreach ($values as &$value) {
                $value = $this->filter($value);
            }
        } else {
            $values = $this->filterValue($values);
        }

        return $values;
    }

    protected function filterValue($value)
    {
        return $value;
    }

}
